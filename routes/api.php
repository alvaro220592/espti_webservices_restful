<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function(){

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::get('categories/{id}/products', [App\Http\Controllers\Api\v1\CategoryController::class, 'products']);
    Route::apiResource('categories', App\Http\Controllers\Api\v1\CategoryController::class);

    Route::apiResource('products', App\Http\Controllers\Api\v1\ProductController::class);
});