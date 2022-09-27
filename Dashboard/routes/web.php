<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeContoller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',DashboardController::class )->middleware(['auth'])->name('dashboard');
Route::get('/dashboard/products',[ProductController::class,'index'] )->middleware(['auth'])->name('dashboard.products');
Route::get('/dashboard/products/create',[ProductController::class,'create'] )->middleware(['auth'])->name('dashboard.products.create');
Route::post('/dashboard/products/store',[ProductController::class,'store'] )->middleware(['auth'])->name('dashboard.products.store');
Route::get('/dashboard/products/edit/{id}',[ProductController::class,'edit'] )->middleware(['auth'])->name('dashboard.products.edit');
Route::put('/dashboard/products/update/{id}',[ProductController::class,'update'] )->middleware(['auth'])->name('dashboard.products.update');
Route::delete('/dashboard/products/delete/{id}',[ProductController::class,'destroy'] )->middleware(['auth'])->name('dashboard.products.delete');

Route::get('/doc', [WelcomeContoller::class, 'welcome'])->name('doc');

Route::get('/user', [UserController::class, 'index']);

require __DIR__.'/auth.php';