<?php

use Ds\Foundations\Commands\Tester\Assert;
// use App\Models\Account;
// use Ds\Foundations\Connection\DatabaseProvider;

describe('One is one number', function(){
  // mock(DatabaseProvider::class);
  // $account = Account::find(7);

  // return Assert::equal($account->id, 7);
  $expect = 1;
  return Assert::equal(1, $expect);
});

describe('Count is one thousand', function(){
  $count = 0;
  for ($i=0; $i < 1000; $i++) { 
    $count += $i;
  }
  return Assert::check($count == 1000);
});