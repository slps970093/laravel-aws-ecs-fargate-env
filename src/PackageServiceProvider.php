<?php

namespace Slps970093\LaravelAwsEcsFargateEnv;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        if (config('aws-ecs-fargate-env.listens', false)) {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('aws-ecs-fargate-env.php'),
            ], 'aws-ecs-fargate-config');

            # nginx php 8.2
            $this->publishes([
                __DIR__ . '/../resources/aws_codebuild/nginx-php82-fpm' => base_path('aws_codebuild/nginx-php82-fpm')
            ],'aws-ecs-fargate-nginx-php82');

            # 建置工具
            $this->publishes([
                __DIR__ . '/../resources/aws_codebuild/build-spec-tool' => base_path('')
            ],'aws-ecs-fargate-build-spec-tool');

            # codebuild 範本
            $this->publishes([
                __DIR__ . '/../resources/aws_codebuild/template' => base_path('aws_codebuild/template')
            ],'aws-ecs-fargate-codebuild');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'aws-ecs-fargate-env');

        $this->app->register(EventServiceProvider::class);
    }
}
