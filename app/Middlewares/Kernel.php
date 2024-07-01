<?php

namespace App\Middlewares;

class Kernel
{
    protected $middlewareAlias = [
        'http' => Http::class,
        'auth' => AuthMiddleware::class
    ];
}
