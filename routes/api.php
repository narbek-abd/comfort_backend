<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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




Route::get('/categories/list', [CategoryController::class, 'list']);
Route::resource('/categories', CategoryController::class);
 
Route::get('/products/list', [ProductController::class, 'list']);
Route::resource('/products', ProductController::class);
Route::delete('/products/image/{product_image}', [ProductController::class, 'destroy_product_image']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user/me', function(Request $request) {
        return $request->user();
    });
});