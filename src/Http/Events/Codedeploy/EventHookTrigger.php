<?php

namespace Slps970093\LaravelAwsEcsFargateEnv\Http\Events\Codedeploy;

use Illuminate\Queue\SerializesModels;

class EventHookTrigger
{
    use SerializesModels;

    private string $triggerName;

    public function __construct(string $triggerName)
    {
        $this->triggerName = $triggerName;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }


    public function getTriggerName(): string
    {
        return $this->triggerName;
    }
}