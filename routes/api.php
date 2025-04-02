<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
   
});
Route::controller(LoginController::class)->group(function(){
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('users', UserController::class, 'getUsers');
});
