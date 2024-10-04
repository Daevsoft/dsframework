<?php

namespace App\Middlewares;

use Ds\Core\Application;
use Ds\Foundations\Validator\ValidationProvider;
use Ds\Foundations\Validator\ValidationRule;

class Kernel extends Application
{
    protected $middlewareAlias = [
        'http' => Http::class,
        'auth' => AuthMiddleware::class,
        'role' => RoleMiddleware::class,
    ];
    public function boot()
    {
        // register any provider here
        ValidationProvider::register(
            new ValidationRule('bail', 'required', function () {

            })
        );
    }
}
