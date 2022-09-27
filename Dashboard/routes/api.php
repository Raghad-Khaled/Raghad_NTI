<?php

use App\Http\Controllers\Api\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('products', [ProductController::class,'index'])->middleware('accept');

Route::get('products/create', [ProductController::class,'create'])->middleware('accept');
Route::post('products/store', [ProductController::class,'store']);
Route::get('products/edit/{id}', [ProductController::class,'edit']);
Route::post('products/update/{id}', [ProductController::class,'update']);
Route::delete('products/delete/{id}', [ProductController::class,'destroy']);
