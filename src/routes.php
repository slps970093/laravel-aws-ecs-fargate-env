<?php

use Illuminate\Support\Facades\Route;
use Slps970093\LaravelAwsEcsFargateEnv\Http\Middleware\LambdaHookAuth;


Route::middleware(LambdaHookAuth::class)
    ->get('aws/codedeploy/lambda-event', [
        \Slps970093\LaravelAwsEcsFargateEnv\Http\Controllers\LambdaEventController::class,
        'index'
    ]);
Route::get('aws/elb/healthcheck', [
    \Slps970093\LaravelAwsEcsFargateEnv\Http\Controllers\ELBController::class,
    'index'
]);