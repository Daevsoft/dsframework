<?php

namespace App\Controllers;

use Ds\Foundations\Config\Env;
use Ds\Foundations\Controller\Controller;
use Ds\Foundations\Debugger\Debug;
use Ds\Foundations\Network\Request;
use Firebase\JWT\JWT;

class IndexController extends Controller
{
    public function index()
    {
        view('welcome');
    }
}
