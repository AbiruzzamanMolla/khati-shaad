<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\MailSenderService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\CustomMenu\app\Enums\DefaultMenusEnum;
use Modules\GlobalSetting\app\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('wsuscart', function ($app) {
            return new CartService();
        });

        $this->app->singleton('wsusmailsender', function ($app) {
            return new MailSenderService();
        });
    }

    public function boot(): void
    {
        try {
            $setting = Cache::memo()->rememberForever('setting', function () {
                return (object) Setting::all()
                    ->pluck('value', 'key')
                    ->toArray();
            });

            $this->setupMailConfiguration($setting);
            $this->setupTimezone($setting);
            $this->initTheme($setting);
            $this->shareViewData($setting);
        } catch (Exception $ex) {
            logError('Error in AppServiceProvider: ' . $ex->getMessage(), $ex);

            if (strtolower(config('app.app_mode')) == 'live' && !app()->isLocal()) {
                Artisan::call('optimize:clear');
                http_response_code(500);
                echo view('errors.init-failed', ['error' => $ex->getMessage()])->render();
                exit;
            }
        }

        $this->registerBladeDirectives();

        Paginator::useBootstrapFour();

        $this->setPaginationForCollection();

        view()->share('nonce', base64_encode(random_bytes(16)));

        $this->loadViewsFrom(resource_path('views/website/components'), 'components');

        $this->loadViewsFrom(resource_path('views/seller'), 'vendor');
    }

    /**
     * @param $setting
     */
    protected function setupMailConfiguration($setting): void
    {
        $mailConfig = [
            'transport'  => 'smtp',
            'host'       => $setting?->mail_host,
            'port'       => $setting?->mail_port,
            'encryption' => $setting?->mail_encryption,
            'username'   => $setting?->mail_username,
            'password'   => $setting?->mail_password,
            'timeout'    => null,
        ];

        config(['mail.mailers.smtp' => $mailConfig]);
        config(['mail.from.address' => $setting?->mail_sender_email]);
        config(['mail.from.name' => $setting?->mail_sender_name]);
    }

    /**
     * @param $setting
     */
    protected function setupPusherConfiguration($setting): void
    {
        config(['broadcasting.connections.pusher.key' => $setting?->pusher_app_key]);
        config(['broadcasting.connections.pusher.secret' => $setting?->pusher_app_secret]);
        config(['broadcasting.connections.pusher.app_id' => $setting?->pusher_app_id]);
        config(['broadcasting.connections.pusher.options.cluster' => $setting?->pusher_app_cluster]);
        config(['broadcasting.connections.pusher.options.host' => 'api-' . $setting?->pusher_app_cluster . '.pusher.com']);
    }

    /**
     * @param $setting
     */
    protected function setupTimezone($setting): void
    {
        config(['app.timezone' => $setting?->timezone]);
    }

    /**
     * @param $theme
     */
    protected function initTheme($setting): void
    {
        $requestedTheme  = request('theme');
        $availableThemes = themeList();
        $defaultTheme    = $setting->theme ?? 1;

        if ($requestedTheme) {
            // Validate against available themes
            $selectedTheme = in_array($requestedTheme, $availableThemes)
            ? $requestedTheme
            : $defaultTheme;

            // Store in session (per user)
            session(['selected_theme' => $selectedTheme]);

        } else {
            // Pull from session if available, otherwise default
            $selectedTheme = session('selected_theme', $defaultTheme);

            // Validate session theme
            if (!in_array($selectedTheme, $availableThemes)) {
                $selectedTheme = $defaultTheme;
                session(['selected_theme' => $defaultTheme]);
            }
        }

        config(['services.theme' => $selectedTheme]);
    }

    protected function setPaginationForCollection(): void
    {
        // register paginate macro
        Collection::macro('paginate', function ($perPage = 16, $total = null, $page = null, $pageName = 'page'): LengthAwarePaginator {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage)->values(),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path'     => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('adminCan', function ($permission) {
            return "<?php if(auth()->guard('admin')->user()->can({$permission})): ?>";
        });

        Blade::directive('endadminCan', function () {
            return '<?php endif; ?>';
        });
    }

    private function removeCache(): void
    {
        removeSectionCache(config('services.theme'), getSessionLanguage());
    }

    /**
     * @param $setting
     */
    public function shareViewData($setting): void
    {
        try {
            $defaultMenus = DefaultMenusEnum::class;

            config([
                'custom.admin_login_prefix' => $setting->admin_login_prefix ?? 'admin',
            ]);

            View::composer('*', function ($view) use ($setting, $defaultMenus) {
                $view->with([
                    'setting'      => $setting,
                    'defaultMenus' => $defaultMenus,
                ]);
            });
        } catch (Exception $e) {
            logError("Error in ViewDataService::shareViewData: ", $e);
            abort(500, $e->getMessage());
        }
    }
}
