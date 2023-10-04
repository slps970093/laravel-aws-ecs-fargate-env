<?php

namespace Slps970093\LaravelAwsEcsFargateEnv\Tests\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use Slps970093\LaravelAwsEcsFargateEnv\PackageServiceProvider;

class ELBControllerTest extends TestCase
{
    public function test_http_ok()
    {
        $httpResult = $this->get('aws/elb/healthcheck');

        $httpResult->assertStatus(200)
            ->assertJsonStructure(['status']);
    }
    protected function getPackageProviders($app)
    {
        Config::set('aws-ecs-fargate-env.enabled', true);
        return [
            PackageServiceProvider::class
        ];
    }
}