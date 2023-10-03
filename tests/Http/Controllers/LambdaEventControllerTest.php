<?php

namespace Slps970093\LaravelAwsEcsFargateEnv\Tests\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;
use Slps970093\LaravelAwsEcsFargateEnv\Http\Events\Codedeploy\EventHookTrigger;
use Slps970093\LaravelAwsEcsFargateEnv\PackageServiceProvider;

class LambdaEventControllerTest extends TestCase
{
    public function test_check_http_response_ok_but_no_trigger_event()
    {
        Event::fake();

        $httpResult = $this->get('aws/codedeploy/lambda-event');

        $httpResult->assertStatus(200)
            ->assertJsonStructure(['status']);

        Event::assertNotDispatched(EventHookTrigger::class);
    }

    public function test_check_http_response_ok_trigger_event()
    {
        Event::fake();

        $httpResult = $this->get('aws/codedeploy/lambda-event?hook=hello');

        $httpResult->assertStatus(200)
            ->assertJsonStructure(['status']);

        Event::assertDispatched(EventHookTrigger::class);
    }

    protected function getPackageProviders($app)
    {
        Config::set('aws-ecs-fargate-env.listens', true);
        return [
          PackageServiceProvider::class
        ];
    }
}