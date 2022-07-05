<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['api'])->group(function () {
    Route::post('/login', [\App\Http\Controllers\UsersController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('products')->controller(\App\Http\Controllers\ProductsController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::put('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'delete');
            Route::delete('/force-delete/{id}', 'forceDelete');
        });

    });
});


