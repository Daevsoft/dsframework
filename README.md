# Dsframework
PHP Ds Framework Next Generation

# Getting Started
To create dsframework project, first you need to install [Composer](https://getcomposer.org/download/). After install, open your directory where you want to create project, then type in terminal `composer create-project dsframework/dsframework` and composer will create a folder automatically include dsframework project in the directory.
- Rename file `.env-copy` to be `.env`.
- Open terminal in your dsframework directory and type `php ds serve`.
- Open browser and go to [http://localhost:8000](http://localhost:8000)

## Setup
Dsframework using `env` file to save configurations. Each application was running, `env` file will converted into cache file.

### Database
open `.env` file, then update value 
```
DRIVER=mysql
HOST=localhost
USERNAME=root
PASSWORD=
DATABASE=mydatabase
PORT=3306
```

## Model

```php
namespace App\Models;

use Ds\Foundations\Connection\Models\DsModel;

class People extends DsModel {
  public $table = 'people';
}
```

## Controller
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
Example : ``welcome.pie.php``
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
<br>

Open file `app/route/web.php`, and type like this
```php
Route::group('/user', UserController::class);
```
Then, in controller class 
`app/controllers/UserController.php` :
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
based on [@daevsoft/dsframework](https://github.com/daevsoft/dsframework)