<?php

include_once dirname(__DIR__).'/vendor/autoload.php';

use Ds\Core\Ds;
use DebugBar\StandardDebugBar;
use Ds\Foundations\Config\Env;
use Symfony\Component\VarDumper\VarDumper;

$ds = new Ds();
$ds->connect();