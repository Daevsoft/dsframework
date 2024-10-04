<?php

namespace App\Middlewares;

use Ds\Foundations\Network\Middleware;
use Ds\Foundations\Network\Request;
use Ds\Foundations\Network\Response;

class RoleMiddleware extends Middleware
{
    public function handle(Request $request, $next): Response | null
    {
        if (in_array(session('role'), $this->options)) {
            return $next($request);
        }
        return null;
        // $user = session('role');
        // if (!is_null($user)) {
        // }
        // return null;
    }
}
