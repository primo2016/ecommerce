<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'core/v1'], function() {
    Route::prefix('categories')->group(function() {
        Route::get('/', App\Http\Controllers\Category\CategoryGetAllController::class);
        Route::get('/{id}', App\Http\Controllers\Category\CategoryGetController::class);
        Route::post('/', App\Http\Controllers\Category\CategoryPostController::class);
        Route::put('/{id}', App\Http\Controllers\Category\CategoryPutController::class);
        Route::delete('/{id}', App\Http\Controllers\Category\CategoryDeleteController::class);
    });

    Route::prefix('products')->group(function() {
        Route::get('/', App\Http\Controllers\Product\ProductGetAllController::class);
        Route::get('/{id}', App\Http\Controllers\Product\ProductGetController::class);
        Route::post('/', App\Http\Controllers\Product\ProductPostController::class);
        Route::put('/{id}', App\Http\Controllers\Product\ProductPutController::class);
        Route::delete('/{id}', App\Http\Controllers\Product\ProductDeleteController::class);
    });

    Route::prefix('discount-codes')->group(function() {
        Route::get('/', App\Http\Controllers\DiscountCode\DiscountCodeGetAllController::class);
        Route::get('/{id}', App\Http\Controllers\DiscountCode\DiscountCodeGetController::class);
        Route::post('/', App\Http\Controllers\DiscountCode\DiscountCodePostController::class);
        Route::put('/{id}', App\Http\Controllers\DiscountCode\DiscountCodePutController::class);
        Route::delete('/{id}', App\Http\Controllers\DiscountCode\DiscountCodeDeleteController::class);
    });

    Route::prefix('code')->group(function() {
        Route::get('/{code}', App\Http\Controllers\DiscountCode\DiscountCodeGetByNameController::class);
    });

    Route::prefix('order')->group(function() {
        Route::post('/', App\Http\Controllers\Order\OrderPostController::class);
    });
});
