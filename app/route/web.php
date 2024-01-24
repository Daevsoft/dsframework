<?php
use App\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index']);
