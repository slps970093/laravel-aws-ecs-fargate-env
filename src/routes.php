<?php

use Illuminate\Support\Facades\Route;


Route::get('aws/codedeploy/lambda-event', [\Slps970093\LaravelAwsEcsFargateEnv\Http\Controllers\LambdaEventController::class,'index']);