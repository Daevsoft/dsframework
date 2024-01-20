<?php

namespace App\Middlewares;

use Ds\Foundations\Common\Func;
use Ds\Foundations\Config\Env;
use Ds\Foundations\Network\Middleware;
use Ds\Foundations\Network\Request;
use Ds\Foundations\Network\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request, $next): Response|null
    {
        $personValidated = $this->validate($request);
        if(is_object($personValidated)){
            $request->add('person', $personValidated);
            return $next($request);
        }
        return null;
    }
    private function validate(Request $request):stdClass|bool {
        $authorization = $request->headers['Authorization'];
        $bearer = substr($authorization, strpos($authorization, ' ') + 1);
        $key = new Key(Env::get('SECRET_KEY'), 'HS256');
        $json = JWT::decode($bearer, $key);
        if(is_object($json)){
            return $json;
        }
        return false;
    }
}
