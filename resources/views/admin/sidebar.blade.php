<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}"><img class="w-75" src="{{ asset($setting->logo) ?? '' }}"
                    alt="{{ $setting->app_name ?? '' }}"></a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ asset($setting->favicon) ?? '' }}"
                    alt="{{ $setting->app_name ?? '' }}"></a>
        </div>

        <ul class="sidebar-menu">
            @adminCan('dashboard.view')
                <li class="{{ isRoute('admin.dashboard', 'active') }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endadminCan

            <li class="menu-header">{{ __('Manage Products') }}</li>

            @if (Module::isEnabled('Product'))
                @include('product::sidebar')
            @endif

            @if (checkAdminHasPermission('coupon.management') ||
                    checkAdminHasPermission('order.management') ||
                    checkAdminHasPermission('refund.management') ||
                    checkAdminHasPermission('location.view') ||
                    checkAdminHasPermission('shipping.management'))
                <li class="menu-header">{{ __('Manage Orders') }}</li>

                @if (Module::isEnabled('Order') && checkAdminHasPermission('order.management'))
                    @include('order::sidebar')
                @endif

                @if (Module::isEnabled('Coupon') && checkAdminHasPermission('coupon.management'))
                    @include('coupon::sidebar')
                @endif

                @adminCan('location.view')
                    <li
                        class="nav-item dropdown {{ Route::is('admin.country.*') || Route::is('admin.state.*') || Route::is('admin.city.*') ? 'active' : '' }}">
                        <a class="nav-link has-dropdown" href="#"><i
                                class="fas fa-map-marker-alt"></i><span>{{ __('Manage Location') }}</span></a>
                        <ul class="dropdown-menu">
                            @adminCan('country.list')
                                <li class="{{ Route::is('admin.country.*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.country.index') }}">{{ __('Country') }}</a>
                                </li>
                            @endadminCan
                            @adminCan('state.list')
                                <li class="{{ Route::is('admin.state.*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.state.index') }}">{{ __('State') }}</a>
                                </li>
                            @endadminCan
                            @adminCan('city.list')
                                <li class="{{ Route::is('admin.city.*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.city.index') }}">{{ __('City') }}</a>
                                </li>
                            @endadminCan
                        </ul>
                    </li>
                @endadminCan

                @adminCan('shipping.management')
                    @if (Module::isEnabled('Shipping'))
                        @include('shipping::sidebar')
                    @endif
                @endadminCan
            @endif

            @if (checkAdminHasPermission('customer.view'))
                <li class="menu-header">{{ __('Manage Customer') }}</li>
                @if (Module::isEnabled('Customer') && checkAdminHasPermission('customer.view'))
                    @include('customer::sidebar')
                @endif
            @endif

            @if (checkAdminHasPermission('sellers.view') ||
                    checkAdminHasPermission('payment.withdraw.management') ||
                    checkAdminHasPermission('kyc.management') ||
                    checkAdminHasPermission('wallet.management'))
                <li class="menu-header">{{ __('Manage Seller') }}</li>

                @if (Module::isEnabled('Customer') && checkAdminHasPermission('sellers.view'))
                    @php
                        $pendingSellersCount = pendingSellerCount();
                    @endphp
                    <li
                        class="{{ isRoute(['admin.manage-seller.all-sellers', 'admin.manage-seller.profile', 'admin.manage-seller.shop.dashboard'], 'active') }}">
                        <a class="nav-link" href="{{ route('admin.manage-seller.all-sellers') }}"><i
                                class="fas fa-briefcase"></i>
                            <span>{{ __('All Sellers') }}</span>
                        </a>
                    </li>

                    <li class="{{ isRoute('admin.manage-seller.pending-sellers', 'active') }}">
                        <a class="nav-link {{ $pendingSellersCount > 0 ? 'beep beep-sidebar' : '' }}"
                            href="{{ route('admin.manage-seller.pending-sellers') }}"><i class="fas fa-user-clock"></i>
                            <span>{{ __('Pending Sellers') }}</span>
                        </a>
                    </li>
                @endif

                @if (Module::isEnabled('KnowYourClient') && checkAdminHasPermission('kyc.management'))
                    @include('knowyourclient::admin.sidebar')
                @endif

                @if (Module::isEnabled('PaymentWithdraw') && checkAdminHasPermission('payment.withdraw.management'))
                    @include('paymentwithdraw::admin.sidebar')
                @endif

                @if (Module::isEnabled('Wallet') && checkAdminHasPermission('wallet.management'))
                    @include('wallet::admin.sidebar')
                @endif
            @endif

            @if (checkAdminHasPermission('blog.category.view') ||
                    checkAdminHasPermission('blog.view') ||
                    checkAdminHasPermission('blog.comment.view') ||
                    checkAdminHasPermission('subscription.view') ||
                    checkAdminHasPermission('team.management') ||
                    checkAdminHasPermission('frontend.view') ||
                    checkAdminHasPermission('menu.view') ||
                    checkAdminHasPermission('page.view') ||
                    checkAdminHasPermission('faq.view') ||
                    checkAdminHasPermission('social.link.management'))

                <li class="menu-header">{{ __('Manage Website') }}</li>

                @if (Module::isEnabled('Frontend') && checkAdminHasPermission('frontend.view'))
                    @include('frontend::sidebar')
                @endif

                @if (Module::isEnabled('CustomMenu') && checkAdminHasPermission('menu.view'))
                    @include('custommenu::sidebar')
                @endif

                @if (Module::isEnabled('PageBuilder') && checkAdminHasPermission('page.view'))
                    @include('pagebuilder::sidebar')
                @endif

                @if (Module::isEnabled('Blog'))
                    @include('blog::sidebar')
                @endif

                @if (Module::isEnabled('Faq') && checkAdminHasPermission('faq.view'))
                    @include('faq::sidebar')
                @endif
            @endif

            @if (checkAdminHasPermission('setting.view') ||
                    checkAdminHasPermission('basic.payment.view') ||
                    checkAdminHasPermission('payment.view') ||
                    checkAdminHasPermission('currency.view') ||
                    checkAdminHasPermission('tax.view') ||
                    checkAdminHasPermission('addon.view') ||
                    checkAdminHasPermission('language.view') ||
                    checkAdminHasPermission('role.view') ||
                    checkAdminHasPermission('admin.view') ||
                    checkAdminHasPermission('clubpoint.management'))
                <li class="menu-header">{{ __('Settings') }}</li>

                @if (Module::isEnabled('GlobalSetting'))
                    <li class="{{ isRoute('admin.settings', 'active') }}">
                        <a class="nav-link" href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>
                    </li>
                @endif

            @endif

            @if (checkAdminHasPermission('newsletter.view') ||
                    checkAdminHasPermission('testimonial.view') ||
                    checkAdminHasPermission('contact.message.view'))
                <li class="menu-header">{{ __('Utility') }}</li>

                @if (Module::isEnabled('NewsLetter') && checkAdminHasPermission('newsletter.view'))
                    @include('newsletter::sidebar')
                @endif

                @if (Module::isEnabled('Testimonial') && checkAdminHasPermission('testimonial.view'))
                    @include('testimonial::sidebar')
                @endif

                @if (Module::isEnabled('ContactMessage') && checkAdminHasPermission('contact.message.view'))
                    @include('contactmessage::sidebar')
                @endif
            @endif

            <li class="nav-item dropdown {{ isRoute('admin.addon.*') ? 'active' : '' }}" id="addon_sidemenu">
                <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-gem"></i>
                    <span>{{ __('Manage Addon') }} </span>

                </a>
                <ul class="dropdown-menu addon_menu">

                    @includeIf('admin.addons')
                </ul>
            </li>
    </aside>
</div>
