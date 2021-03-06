<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
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
Route::get('/categories/count', [CategoryController::class, 'count']);
Route::resource('/categories', CategoryController::class);

Route::get('/products/list', [ProductController::class, 'list']);
Route::get('/products/count', [ProductController::class, 'count']);
Route::resource('/products', ProductController::class);

Route::get('/product/comments/{product}', [ProductController::class, 'comments']);

Route::post('/product/comments', [CommentController::class, 'store'])->name('product.comments.store');
Route::put('/product/comments/{comment}', [CommentController::class, 'update']);
Route::delete('/product/comments/{comment}', [CommentController::class, 'destroy']);

Route::delete('/products/image/{product_image}', [ProductController::class, 'destroy_product_image']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/count', [OrderController::class, 'count']);



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::put('/product/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/product/comments/{comment}', [CommentController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

    Route::get('/user/me', function(Request $request) {
        return $request->user();
    });

    Route::post('logout', [AuthController::class, 'logout']);
});