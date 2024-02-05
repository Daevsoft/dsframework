<?php
use App\Controllers\IndexController;
use Ds\Foundations\Routing\Route;

Route::get('/', [IndexController::class, 'index']);
