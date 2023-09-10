<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductColorsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSizesController;
use App\Http\Controllers\ProductVariantsController;

// User Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/user/{id}', [AuthController::class, 'updateUser'])->middleware('auth:sanctum');

// Category API routes
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{category_name}', [categorycontroller::class, 'show']);
Route::post('/category', [categorycontroller::class, 'store']);
Route::post('/category/{category_id}', [categorycontroller::class, 'update']);
Route::delete('/category/{category_id}', [categorycontroller::class, 'destroy']);

// Product API routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/fetchProductwhitcategories', [ProductController::class, 'fetchProductwhitcategories']);
Route::get('/products/{products_id}', [ProductVariantsController::class, 'findproductwithimages']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{products_id}', [ProductController::class, 'update']);
Route::delete('/products/{products_id}', [ProductController::class, 'destroy']);
Route::get('/search/{keyword}', [ProductController::class, 'search']);

// Product Variations API routes
Route::get('/variations', [ProductVariantsController::class, 'index']);
Route::get('/variations/{product_id}', [ProductVariantsController::class, 'find']);

// Sizes API routes
Route::get('/sizes', [ProductSizesController::class, 'index']);
Route::get('/sizes/{id}', [ProductsizesController::class, 'show']);
Route::post('/sizes', [ProductsizesController::class, 'create']);
Route::delete('/sizes/{id}', [ProductsizesController::class, 'destroy']);

// Colors API routes
Route::get('/colors', [ProductColorsController::class, 'index']);
Route::get('/colors/{id}', [ProductColorsController::class, 'show']);
Route::post('/colors', [ProductColorsController::class, 'create']);
Route::delete('/colors/{id}', [ProductColorsController::class, 'destroy']);

// Coupons API routes
Route::get('/coupon', [CouponController::class, 'index']);
Route::get('/coupon/{id}', [CouponController::class, 'show']);
Route::post('/coupon', [CouponController::class, 'store']);
Route::post('/coupon/{code}', [CouponController::class, 'find']);
Route::delete('/coupon/{id}', [CouponController::class, 'destroy']);

// Order API routes
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order_id}', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{order_id}', [OrderController::class, 'update']);
Route::delete('/orders/{order_id}', [OrderController::class, 'destroy']);

// Notifications API routes
Route::get('/notifications', [NotificationController::class, 'index']);
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
Route::delete('/notifications', [NotificationController::class, 'destroyALL']);

// Payment API routes
Route::post('/stripe', [CheckoutController::class, 'createPaymentIntent']);
