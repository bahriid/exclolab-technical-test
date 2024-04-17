<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('forgot', [UserController::class, 'sendLink']);

route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', [UserController::class, 'index']);

    Route::post('logout', [UserController::class, 'logout']);
});

Route::any('{any}', function(){
    return response()->json([
        'status' => false,
        'message' => 'Invalid Endpoint'
    ], 404);
});


