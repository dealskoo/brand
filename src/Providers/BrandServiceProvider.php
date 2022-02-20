<?php

namespace Dealskoo\Brand\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Support\ServiceProvider;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/brand.php', 'brand');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/brand.php' => config_path('brand.php')
            ], 'config');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/brand')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/seller.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'brand');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'brand');

        AdminMenu::route('admin.brands.index', 'brand::brand.brands', [], ['icon' => 'uil-medal', 'permission' => 'brands.index'])->order(8);

        PermissionManager::add(new Permission('brands.index', 'Brand Lists'));
        PermissionManager::add(new Permission('brands.show', 'View Brand'), 'brands.index');
        PermissionManager::add(new Permission('brands.edit', 'Edit Brand'), 'brands.index');
        PermissionManager::add(new Permission('brands.destroy', 'Destroy Brand'), 'brands.index');

        SellerMenu::route('admin.brands.index', 'brand::brand.brands', [], ['icon' => 'uil-medal me-1'])->order(4);
    }
}
