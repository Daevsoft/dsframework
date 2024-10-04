<?php

namespace App\Middlewares;

use Ds\Foundations\Config\Env;
use Ds\Foundations\Network\Middleware;
use Ds\Foundations\Network\Request;
use Ds\Foundations\Network\Response;
use Ds\Foundations\Session\Session;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class AuthMiddleware extends Middleware
{
    public function handle(Request $request, $next): Response | null
    {
        $user = session('user');
        if (!is_null($user)) {
            return $next($request);
        }
        return null;
    }
    private function validate(Request $request): stdClass | bool
    {
        $authorization = $request->headers['Authorization'];
        $bearer = substr($authorization, strpos($authorization, ' ') + 1);
        $key = new Key(Env::get('SECRET_KEY'), 'HS256');
        $json = JWT::decode($bearer, $key);
        if (is_object($json)) {
            return $json;
        }
        return false;
    }
}
