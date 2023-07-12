<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\websiteUsersController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
{
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    // put all routes under here
}

);

Route::get('/users',[userController::class,'index']);
// Route::post('/register',[userController::class,'register']);
// Route::post('/register', [AuthController::class, 'register']);

// User Authentication
Route::post('/login', 'App\Http\Controllers\userController@login');
Route::post('/register', 'App\Http\Controllers\userController@register');
Route::post('/register', 'App\Http\Controllers\AuthController@register');


//category api routes
Route::get('/category', 'App\Http\Controllers\categorycontroller@index');
Route::get('/category/{category_name}', 'App\Http\Controllers\categorycontroller@show');
Route::post('/category', 'App\Http\Controllers\categorycontroller@store');
Route::post('/category/{category_id}', 'App\Http\Controllers\categorycontroller@update');
Route::delete('/category/{category_id}', 'App\Http\Controllers\categorycontroller@destroy');

//product api routes
Route::get('/products', 'App\Http\Controllers\ProductController@index');
Route::get('/fetchProductwhitcategories', 'App\Http\Controllers\ProductController@fetchProductwhitcategories');
Route::get('/products/{products_id}', 'App\Http\Controllers\productVariants@findproductwithimages');
Route::post('/products', 'App\Http\Controllers\productcontroller@store');
Route::put('/products/{products_id}', 'App\Http\Controllers\productcontroller@update');
Route::delete('/products/{products_id}', 'App\Http\Controllers\productcontroller@destroy');


// color api routes

Route::get('/colors', 'App\Http\Controllers\ProductColorsController@index');
Route::get('/colors/{color_id}', 'App\Http\Controllers\ProductColorsController@show');
Route::post('/colors', 'App\Http\Controllers\ProductColorsController@create');
Route::delete('/colors/{color_id}', 'App\Http\Controllers\ProductColorsController@destroy');


// sizes api routes

Route::get('/sizes', 'App\Http\Controllers\ProductsizesController@index');
Route::get('/sizes/{id}', 'App\Http\Controllers\ProductsizesController@show');
Route::post('/sizes', 'App\Http\Controllers\ProductsizesController@create');
Route::delete('/sizes/{id}', 'App\Http\Controllers\ProductsizesController@destroy');


// colors api routes

Route::get('/colors', 'App\Http\Controllers\ProductcolorsController@index');
Route::get('/colors/{id}', 'App\Http\Controllers\ProductcolorsController@show');
Route::post('/colors', 'App\Http\Controllers\ProductcolorsController@create');
Route::delete('/colors/{id}', 'App\Http\Controllers\ProductcolorsController@destroy');

// product variations api routes
Route::get('/variations', 'App\Http\Controllers\productVariants@index');
Route::get('/filters', 'App\Http\Controllers\productVariants@find');
Route::get('/variations/{product_id}', 'App\Http\Controllers\productVariants@find');