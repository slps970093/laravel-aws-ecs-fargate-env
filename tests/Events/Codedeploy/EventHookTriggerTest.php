<?php

namespace Slps970093\LaravelAwsEcsFargateEnv\Tests\Events\Codedeploy;

use Orchestra\Testbench\TestCase;
use Slps970093\LaravelAwsEcsFargateEnv\Http\Events\Codedeploy\EventHookTrigger;

class EventHookTriggerTest extends TestCase
{
    public function test_get_event()
    {
        $event = new EventHookTrigger('monkey');

        $this->assertEquals('monkey',$event->getTriggerName());
    }
}