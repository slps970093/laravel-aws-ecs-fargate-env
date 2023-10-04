<?php

namespace Slps970093\LaravelAwsEcsFargateEnv;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Slps970093\LaravelAwsEcsFargateEnv\Http\Events\Codedeploy\EventHookTrigger;

class EventServiceProvider extends BaseEventServiceProvider
{

    public function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        $this->listen = [
            EventHookTrigger::class => config('aws-ecs-fargate-env.listens', [])
        ];

        $events = app('events');

        foreach (config('aws-ecs-fargate-env.listens', []) as $listener) {
            $events->listen(EventHookTrigger::class, $listener);
        }
    }
}