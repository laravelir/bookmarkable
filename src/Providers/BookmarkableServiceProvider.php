<?php

namespace Laravelir\Bookmarkable\Providers;

use Illuminate\Support\ServiceProvider;
use Laravelir\Bookmarkable\Console\Commands\InstallPackageCommand;
use Laravelir\Bookmarkable\Facades\Bookmarkable;

class BookmarkableServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../../config/bookmarkable.php", 'bookmarkable');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->registerFacades();
    }

    public function boot(): void
    {
        $this->registerCommands();
    }

    private function registerFacades()
    {
        $this->app->bind('bookmarkable', function ($app) {
            return new Bookmarkable();
        });
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                InstallPackageCommand::class,
            ]);
        }
    }

    public function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../../config/bookmarkable.php' => config_path('bookmarkable.php')
        ], 'bookmarkable-config');
    }

    protected function publishMigrations()
    {
        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../database/migrations/create_bookmarkable_tables.stub' => database_path() . "/migrations/{$timestamp}_bookmarkable_tables.php",
        ], 'bookmarkable-migrations');
    }

    // private function registerRoutes()
    // {
    //     Route::group($this->routeConfiguration(), function () {
    //         $this->loadRoutesFrom(__DIR__ . '/../../routes/bookmarkable.php', 'bookmarkable-routes');
    //     });
    // }

    // private function routeConfiguration()
    // {
    //     return [
    //         'prefix' => config('bookmarkable.routes.prefix'),
    //         'middleware' => config('bookmarkable.routes.middleware'),
    //         'as' => 'bookmarkable.'
    //     ];
    // }

}
