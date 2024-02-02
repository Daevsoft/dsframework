# PHP DsFramework
PHP DsFramework Next Generation MVC framework. Inspired by Laravel and CodeIgniter framework with cutting edge complexity proccess.

## Getting Started
DsFramework support for PHP 8.1 or latest to work properly. <br>
<b>Requirements :</b>
* PHP 8.1 or [latest](https://php.net)
* [Composer](https://getcomposer.org/download/)

### How to run?
First, install dependencies from composer with `composer install` command in terminal. <br>
Second, run a project with `php ds serve` command. Done.

### Connect Database
To connecting into database, open the `.env` file and set your database configuration in the name prefix `DB_` property.<br>
<b>Example: </b>
```.env
DB_DRIVER=mysql
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=mypassword
DB_NAME=somethingdb
DB_PORT=3306
SSL_CERT=
SSL_VERIFY=false
``` 
Leave `DB_NAME` blank if a web application does not require a database. 

### ENV File
The `.env` file is a constant value for the application configuration. When the file has been modified, refresh the configuration cache with the `php ds config` command in the terminal.

## Model
Open terminal and write a command : `php ds add:model modelName` <br>
Or generate multiple model : `php ds add:model modelname1 modelname2 modelnameOther` <br>
Example : `php ds add:model People` then model file `app/models/People.php` will be generated
```php
namespace App\Models;

use Ds\Foundations\Connection\Models\DsModel;

class People extends DsModel {
  public $table = 'people';
}
```

## Controller
Open terminal and write a command : `php ds add:controller ControllerName` <br>
Or generate multiple controller : `php ds add:controller controllername1 controllername2 controllernameOther` <br>
Example of controller :
```php
class IndexController extends Controller
{
    public function index()
    {
        view('home');
    }

    public function peopleList(){
        $data = People::all();
        // Response is json encode
        return [ 'people_list' => $data ];
    }

    public function savePeople(Request $request){
        // Save json data
        People::save($request->json());
        // OR specify request field
        People::save([
            'fullname' => $request->fullname,
            'phone' => $request->phone
        ]);
        // OR all Request Form Field Data
        People::save($request->all());
    }

    public function welcomePage()
    {
        // Response is Views/Html render
        view('welcome');
    }
}
```

## Routing
The routing of web application is defined in the `app/route/web.php` file. 
Example :
```php
// with callback controller method
Route::get('/', [IndexController::class, 'index']);
Route::get('/welcome', [IndexController::class, 'welcomePage']);
Route::get('/people', [IndexController::class, 'peopleList']);
Route::post('/people/save', [IndexController::class, 'savePeople']);

// simple route
Route::get('/sample/subsample', function () {
    echo 'Welcome to routing!';
});

// With uri as parameter
Route::get('/sample/{arg1}/subsample/{arg2}', function ($arg1, $arg2) {
    echo 'Uri param ' . $arg1 . ' - ' . $arg2;
});
// With middleware
Route::middleware(['auth'], function () {
    Route::get('/mypage/{arg1}/othersub/{mysub}', function ($arg1, $mysub) {
        echo 'page param ' . $arg1 . ' - ' . $mysub;
    });

    Route::get('/mypage/page/{arg1}/{arg2}', function ($arg1, $arg2) {
        echo 'page ' . $arg1 . ' param ' . $arg2;
    });
});
// or with middleware in spacific route
Route::get('/people-list', [ IndexController::class, 'index' ])->middleware('api-auth');
// or multiple middleware
Route::get('/people-list', [ IndexController::class, 'index' ])
            ->middleware([ 'api-auth', 'company-auth' ]);

// With grouping /admin/...
Route::group('admin', function () {
    Route::get('/get-string', function () {
        // will return Json Encode
        return ['username' => 'Deva Arofi'];
    });
});
```

## View
Open terminal and write a command : `php ds add:view viewname` <br>
Or generate multiple view : `php ds add:view viewname1 viewname2 viewnameOther` <br>
Or generate in subdirectory : `php ds add:view pages/viewname` and `views/pages/` directory will generate automatically. <br>
<br>
Example view file : `welcome.pie.php`
```html
<html>
    <head>
        <title>{{ $appname }}</title>
    </head>
    <body>
        Welcome to Web App
    </body>
</html>
```

### Pie Cheat Sheet
|Syntax|Closing|Description|
|-|-|-|
|``{{ ... }}``|``-``|Same as ``echo(...)`` in php|
|``<< ... >>``|``-``|Same as ``<?php ... ?>`` in php|
|``@slot(..)``|``-``|Create a slot for templating|
|``@use(..)``|``-``|To use a template that includes ``@slot`` syntax|
|``@part(..)``|``@endpart``|To inject a content into ``@slot(..)``|
|``@foreach(..):``|``@endforeach``|Same as ``<?php foreach(..): `` in php|
|``@if(...):``|``@endif``|Same as ``<?php if(..): ?>`` in php|


# Advanced

## Middleware
```php
class AuthMiddleware implements Middleware
{
    public function handle(Request $request, $next): Response|null
    {
        // if middleware was passed
        if(true){
            return $next($request);
        }else{
            return null;
        }
    }
}
```
Assign middleware into Route
```php
Route::get('/all-person', [ PersonController::class, 'index' ])
            ->middleware(['auth']);
```

### Passing data from Middleware to Controller
```php
class AuthMiddleware implements Middleware
{
    public function handle(Request $request, $next): Response|null
    {
        // find person data by id
        $personData = Person::find($request->person_id); 
        // if middleware was passed
        if($personData != null){
            $request->add('person', $personData);
            return $next($request);
        }else{
            return null;
        }
    }
    ...
}
```
Then retrieve data in controller
```php
class PersonController extends Controller
{
    public function index(Request $request)
    {
        $person = $request->person;

        var_dump($person);
    }
    ...
}
```

## Routing
If you want to grouping routes based on controller, you can write like this :
`app/route/web.php`
```php
Route::group('/user', UserController::class);
```
Then, in controller class :
`app/controllers/UserController.php`
```php
class UserController extends Controller 
{
    #[Get('/all')]
    public void index()
    {
        ...
    }

    #[Get('/detail/{userId}')]
    public void userById($userId)
    {
        ...
    }

    #[Post('/save')]
    public void saveUser(Request $request)
    {
        ...
    }

    #[Delete('/delete')]
    public void deleteUser()
    {
        ...
    }
}
```
Then, you can access by address like this :<br>
GET | `http://localhost:8000/user/all` <br>
GET | `http://localhost:8000/user/detail/3` <br>
POST | `http://localhost:8000/user/save` <br>
DELETE | `http://localhost:8000/user/delete` <br>
<br>

## Testing
Dsframework support for testing and unit test. <br />
Write `php ds add:test SampleTest OtherTest` in terminal, and test file will generate automatically into `\tests` folder.

```php
class SampleTest extends TestCase{
  public function test_sample(){
    $expect = 'hello';
    $this->assertTrue('hello' == $expect);
  }
}
```

### Unit Test
Or, using `--unit` options to generate unit test file. <br>
`php ds add:test --unit SampleTest` command.
```php
describe('Count is one thousand', function(){
  $count = 0;
  for ($i=0; $i < 1000; $i++) { 
    $count += $i;
  }
  return Assert::check($count == 1000);
});
// OR mock DatabaseProvider to support Model
describe('One is one number', function(){
  mock(DatabaseProvider::class);
  $account = Account::find(7);

  return Assert::equal($account->id, 7);
});

```
### Run Test
To run your test file, type a command `php ds test` or `php ds test --unit` for unit test file. Then, all test files will be executed.
<br/>

based on [@daevsoft/dsframework](https://github.com/daevsoft/dsframework)