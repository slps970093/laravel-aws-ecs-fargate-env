<?php

namespace Slps970093\LaravelAwsEcsFargateEnv;

use Illuminate\Support\ServiceProvider;

class LaravelAwsEcsFargateEnvServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-aws-ecs-fargate-env');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-aws-ecs-fargate-env');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-aws-ecs-fargate-env.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-aws-ecs-fargate-env'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-aws-ecs-fargate-env'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-aws-ecs-fargate-env'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-aws-ecs-fargate-env');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-aws-ecs-fargate-env', function () {
            return new LaravelAwsEcsFargateEnv;
        });
    }
}
