<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

Route::middleware(['api'])->group(function () {
    // Categories API Routes
    /*
        Available Routes:
        GET    /api/categories          - Get all categories
        POST   /api/categories          - Create new category
        GET    /api/categories/{id}     - Get single category
        PUT    /api/categories/{id}     - Update category
        DELETE /api/categories/{id}     - Delete category
    */
    Route::apiResource('categories', CategoryController::class);
    // Route::prefix('categories')->group(function () {
    //     Route::get('/', [CategoryController::class, 'index']);
    //     Route::post('/', [CategoryController::class, 'store']);
    //     Route::get('/{category}', [CategoryController::class, 'show']);
    //     Route::put('/{category}', [CategoryController::class, 'update']);
    //     Route::delete('/{category}', [CategoryController::class, 'destroy']);
    // });
    // Products API Routes
    /*
        Available Routes:
        GET    /api/products          - Get all products
        POST   /api/products          - Create new product
        GET    /api/products/{id}     - Get single product
        PUT    /api/products/{id}     - Update product
        DELETE /api/products/{id}     - Delete product
    */
    Route::apiResource('products', ProductController::class);
});
