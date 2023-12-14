<?php


namespace Enan\PathaoCourier;


use Illuminate\Support\ServiceProvider;
use Enan\PathaoCourier\Commands\PathaoCourierCommand;

class PathaoCourierServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/pathao-courier.php',
            'pathao-courier-config'
        );

        // Migration
        $this->publishes([
            __DIR__ . '/../database' => database_path(),
        ], 'pathao-migration');
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // Config
        $this->publishes([
            __DIR__ . '/../config/pathao-courier.php' => config_path('pathao-courier.php')
        ], 'pathao-courier-config');

        // Migration
        $this->publishes([
            __DIR__ . '/../database' => database_path(),
        ], 'pathao-migration');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PathaoCourierCommand::class,
            ]);
        }
    }
}
