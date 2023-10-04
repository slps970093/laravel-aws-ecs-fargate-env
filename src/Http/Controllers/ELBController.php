<?php

namespace Slps970093\LaravelAwsEcsFargateEnv\Http\Controllers;

class ELBController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => true]);
    }
}