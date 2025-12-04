<?php

use App\Http\Controllers\Admin\AddonsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
/*  Start Admin panel Controller  */
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

$adminPrefix = config('custom.admin_login_prefix', 'admin');

if ($adminPrefix !== 'admin') {
    Route::prefix($adminPrefix)->name('admin.')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('store-login', [AuthenticatedSessionController::class, 'store'])->name('store-login');
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/forget-password', [PasswordResetLinkController::class, 'custom_forget_password'])->name('forget-password');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'custom_reset_password_page'])->name('password.reset');
        Route::post('/reset-password-store/{token}', [NewPasswordController::class, 'custom_reset_password_store'])->name('password.reset-store');
    });
} else {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('store-login', [AuthenticatedSessionController::class, 'store'])->name('store-login');
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/forget-password', [PasswordResetLinkController::class, 'custom_forget_password'])->name('forget-password');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'custom_reset_password_page'])->name('password.reset');
        Route::post('/reset-password-store/{token}', [NewPasswordController::class, 'custom_reset_password_store'])->name('password.reset-store');
    });
}

Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    /* Start admin auth route */
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    /* End admin auth route */

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard']);
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::resource('country', CountryController::class);
        Route::resource('city', CityController::class);
        Route::resource('state', StateController::class);
        Route::get('/all-states-by-country/{id}', [StateController::class, 'getAllStateByCountry'])->name('get.all.states.by.country');

        Route::get('/all-cities-by-state/{id}', [CityController::class, 'getAllCitiesByState'])->name('get.all.cities.by.state');

        Route::controller(AdminProfileController::class)->group(function () {
            Route::get('edit-profile', 'edit_profile')->name('edit-profile');
            Route::put('profile-update', 'profile_update')->name('profile-update');
            Route::put('update-password', 'update_password')->name('update-password');
        });

        Route::get('role/assign', [RolesController::class, 'assignRoleView'])->name('role.assign');
        Route::post('role/assign/{id}', [RolesController::class, 'getAdminRoles'])->name('role.assign.admin');
        Route::put('role/assign', [RolesController::class, 'assignRoleUpdate'])->name('role.assign.update');
        Route::resource('/role', RolesController::class);

        Route::resource('admin', AdminController::class)->except('show');
        Route::put('admin-status/{id}', [AdminController::class, 'changeStatus'])->name('admin.status');
        Route::get('settings', [SettingController::class, 'settings'])->name('settings');
        Route::get('sync-modules', [AddonsController::class, 'syncModules'])->name('addons.sync');
    });
});
