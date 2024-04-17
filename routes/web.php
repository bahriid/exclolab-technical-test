<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('forgot/password', [UserController::class, 'indexForgotPassword'])->name('password.reset');
Route::post('reset/password', [UserController::class, 'forgotPassword'])->name('password.resetting');
