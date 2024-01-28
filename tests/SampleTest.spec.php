<?php

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase{
  public function test_sample(){
    $expect = 'hello';
    $this->assertTrue('hello' == $expect);
  }
}