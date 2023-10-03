<?php

namespace Slps970093\LaravelAwsEcsFargateEnv\Http\Controllers;

use Illuminate\Http\Request;
use Slps970093\LaravelAwsEcsFargateEnv\Http\Events\Codedeploy\EventHookTrigger;

class LambdaEventController
{
    public function index(Request $request)
    {
        if (!empty($request->get('hook', ''))) {
            event(new EventHookTrigger($request->get('hook')));
        }

        return response()->json(['status' => true]);
    }
}