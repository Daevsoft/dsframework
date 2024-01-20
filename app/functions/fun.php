<?php

use Ds\Foundations\Common\Func;

function response($status, $data){
  return ['status' => $status, 'data' => $data];
}

function check($var){
  Func::check($var, true);
}