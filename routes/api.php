<?php

use App\Http\Controllers\API\v1\CategoriesController;
use App\Http\Controllers\API\v1\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function() {
    Route::get('category/{id}/products', [CategoriesController::class, 'products']);
    Route::apiResource('categories', CategoriesController::class);
    Route::apiResource('products', ProductsController::class);    
});
