<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware'=>'auth:api'],function(){
    Route::get('get-products/{id?}', [ProductController::class, 'getAllProducts']);
    Route::post('create-product', [ProductController::class, 'store']);
    Route::put('update-product/{id}', [ProductController::class, 'update']);

    Route::get('check-auth', [AuthController::class, 'validateToken']);
    
});
