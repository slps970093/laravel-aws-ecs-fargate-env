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

    public function test_check_http_auth_fail()
    {
        Config::set('aws-ecs-fargate-env.hook.auth', true);
        Config::set('aws-ecs-fargate-env.hook.token', 66666);

        $httpResult = $this->get('aws/codedeploy/lambda-event');

        $httpResult->assertStatus(403);
    }

    public function test_check_http_auth_success()
    {
        Config::set('aws-ecs-fargate-env.hook.auth', true);
        Config::set('aws-ecs-fargate-env.hook.token', 66666);

        $httpResult = $this->get('aws/codedeploy/lambda-event',[
            'x-auth-token' => 66666
        ]);

        $httpResult->assertStatus(200)
            ->assertJsonStructure(['status']);
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
        Config::set('aws-ecs-fargate-env.enabled', true);
        return [
          PackageServiceProvider::class
        ];
    }
}