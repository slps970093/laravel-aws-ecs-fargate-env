<?php

namespace Slps970093\LaravelAwsEcsFargateEnv;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Slps970093\LaravelAwsEcsFargateEnv\Skeleton\SkeletonClass
 */
class LaravelAwsEcsFargateEnvFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-aws-ecs-fargate-env';
    }
}
