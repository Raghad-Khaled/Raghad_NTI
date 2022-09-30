<?php

use App\Http\Controllers\PostsContoller;
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

Route::get('/dashboard',[PostsContoller::class,'index'] )->middleware(['auth'])->name('dashboard');
Route::post('/dashboard/posts/store',[PostsContoller::class,'store'] )->middleware(['auth'])->name('dashboard.posts.store');
Route::delete('/dashboard/posts/delete/{id}',[PostsContoller::class,'destroy'] )->middleware(['auth'])->name('dashboard.posts.delete');
Route::get('/dashboard/posts/{id}',[PostsContoller::class,'find'] )->middleware(['auth'])->name('dashboard.post.index');

require __DIR__.'/auth.php';
