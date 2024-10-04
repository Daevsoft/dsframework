<?php

namespace App\Middlewares;

use Ds\Foundations\Common\Func;
use Ds\Foundations\Network\Middleware;
use Ds\Foundations\Network\Response;
use Ds\Foundations\Security\Csrf;

class Http extends Middleware
{
    public function handle($request, $next): Response
    {
        Func::check('HTTP Middleware successfully!');
        Csrf::generate();
        return $next();
    }
}
