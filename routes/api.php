<?php

use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('category/{id}/products', [CategoriesController::class, 'products']);
Route::apiResource('products', ProductsController::class);
Route::apiResource('categories', CategoriesController::class);