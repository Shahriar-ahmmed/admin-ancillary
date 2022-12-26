<?php

namespace Ahmmed\AdminAncillary;

use Illuminate\Support\ServiceProvider;

class AdminAncillaryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Loading routes
        require __DIR__ . '/routes.php';

        // Publishing views
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/admin-ancillary'),
        ], 'admin-ancillary');

        // Publishing public assets
        $this->publishes([
            __DIR__ . '/assets' => public_path('admin-ancillary'),
        ], 'admin-ancillary');

        // Publishing migrations
        $this->publishes([
            __DIR__ . '/migrations' => database_path('/migrations'),
        ], 'admin-ancillary');

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MenuOrderController', 'Ahmmed\AdminAncillary\Controllers\MenuOrderController');
        $this->app->bind('MenuController', 'Ahmmed\AdminAncillary\Controllers\MenuController');
        $this->app->bind('RoleManagementController', 'Ahmmed\AdminAncillary\Controllers\RoleManagementController');
        $this->app->bind('SetPermissionController', 'Ahmmed\AdminAncillary\Controllers\SetPermissionController');
        $this->app->bind('UserManagementController', 'Ahmmed\AdminAncillary\Controllers\UserManagementController');
        $this->app->bind('HomeController', 'Ahmmed\AdminAncillary\Controllers\HomeController');
        $this->app->bind('UserController', 'Ahmmed\AdminAncillary\Controllers\UserController');
        $this->app->bind('AppSettingsController', 'Ahmmed\AdminAncillary\Controllers\AppSettingsController');

    }
}
