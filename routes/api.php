<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(ProductController::class)->group(function() {
    Route::get('/products', 'getProductsList')->name('api-getProductsList');
    Route::get('/products/{id}', 'getProduct')->name('api-getProduct');
    Route::post('/products', 'createProduct')->name('api-createProduct');
    Route::post('/products/{id}/reviews', 'createProductReview')->name('api-createProductReview');
    Route::put('/products/{id}', 'updateProduct')->name('api-updateProduct');
    Route::delete('/products/{id}', 'deleteProduct')->name('api-deleteProduct');
});