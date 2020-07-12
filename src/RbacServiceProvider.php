<?php

namespace Itstructure\LaRbac;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Itstructure\LaRbac\Commands\{PublishCommand, DatabaseCommand, AdminCommand};
use Itstructure\GridView\GridViewServiceProvider;
use Itstructure\GridView\Grid;

/**
 * Class RbacServiceProvider
 *
 * @package Itstructure\LaRbac
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class RbacServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(RbacRouteServiceProvider::class);
        $this->app->register(RbacAuthServiceProvider::class);
        $this->app->register(GridViewServiceProvider::class);

        $this->registerCommands();
    }

    public function boot()
    {
        // Loading settings
        $this->loadViews();
        $this->loadTranslations();
        $this->loadMigrations();


        // Publish settings
        $this->publishConfig();
        $this->publishViews();
        $this->publishTranslations();
        $this->publishMigrations();
        $this->publishSeeds();


        // Global view's params
        View::share('rbacLayout', config('rbac.layout'));
        View::share('rbacRowsPerPage', config('rbac.rowsPerPage', Grid::INIT_ROWS_PER_PAGE));
    }


    /*
    |--------------------------------------------------------------------------
    | COMMAND SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Register commands.
     * @return void
     */
    private function registerCommands(): void
    {
        $this->commands(Commands\PublishCommand::class);
        $this->commands(Commands\DatabaseCommand::class);
        $this->commands(Commands\AdminCommand::class);
    }


    /*
    |--------------------------------------------------------------------------
    | LOADING SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Set directory to load views.
     * @return void
     */
    private function loadViews(): void
    {
        $this->loadViewsFrom($this->packagePath('resources/views'), 'rbac');
    }

    /**
     * Set directory to load translations.
     * @return void
     */
    private function loadTranslations(): void
    {
        $this->loadTranslationsFrom($this->packagePath('resources/lang'), 'rbac');
    }

    /**
     * Set directory to load migrations.
     * @return void
     */
    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom($this->packagePath('database/migrations'));
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLISH SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Publish config.
     * @return void
     */
    private function publishConfig(): void
    {
        $configPath = $this->packagePath('config/rbac.php');

        $this->publishes([
            $configPath => config_path('rbac.php'),
        ], 'config');

        $this->mergeConfigFrom($configPath, 'rbac');
    }

    /**
     * Publish views.
     * @return void
     */
    private function publishViews(): void
    {
        $this->publishes([
            $this->packagePath('resources/views') => resource_path('views/vendor/rbac'),
        ], 'views');
    }

    /**
     * Publish translations.
     * @return void
     */
    private function publishTranslations(): void
    {
        $this->publishes([
            $this->packagePath('resources/lang') => resource_path('lang/vendor/rbac'),
        ], 'lang');
    }

    /**
     * Publish migrations.
     * @return void
     */
    private function publishMigrations(): void
    {
        $this->publishes([
            $this->packagePath('database/migrations') => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Publish seeds.
     * @return void
     */
    private function publishSeeds(): void
    {
        $this->publishes([
            $this->packagePath('database/seeds') => database_path('seeds'),
        ], 'seeds');
    }


    /*
    |--------------------------------------------------------------------------
    | OTHER SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Get package path.
     * @param $path
     * @return string
     */
    private function packagePath($path): string
    {
        return __DIR__ . "/../" . $path;
    }
}
