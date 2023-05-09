<?php

use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductsController::class);
Route::apiResource('categories', CategoriesController::class);