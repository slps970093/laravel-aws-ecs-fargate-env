<?php

namespace Slps970093\LaravelAwsEcsFargateEnv\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LambdaHookAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        if ( config('aws-ecs-fargate-env.hook.auth', false) ) {
            if ( $request->header('x-auth-token', '') != config('aws-ecs-fargate-env.hook.token') ) {
                App::abort(403,'auth failed');
            }
        }

        return $next($request);
    }
}