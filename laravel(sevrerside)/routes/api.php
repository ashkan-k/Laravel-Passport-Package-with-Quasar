<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UserController;
use \App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('users', UserController::class)->except(['show' , 'update']);

// Return User Data For Edit
Route::put('user/{user}' , [UserController::class , 'edit'])->name('users.edit');
// Update User With POST method
Route::post('user/update/{user}' , [UserController::class , 'update'])->name('users.edit');


Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class , 'login']);
    Route::post('signup', [AuthController::class , 'signup']);
    Route::get('check_login' , [AuthController::class , 'CheckLogin']);

    Route::group([ 'middleware' => 'auth:api' ], function () {

        Route::get('logout', [AuthController::class , 'logout']);
        Route::get('user', [AuthController::class , 'user']);
        Route::post('refresh_token' , [AuthController::class , 'refreshToken']);

    });

});
