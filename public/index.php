<?php

include_once dirname(__DIR__).'/vendor/autoload.php';

use Ds\Core\Ds;
use DebugBar\StandardDebugBar;
use Ds\Foundations\Config\Env;
use Symfony\Component\VarDumper\VarDumper;

require_once './app/functions/fun.php';

$ds = new Ds();
$ds->connect();