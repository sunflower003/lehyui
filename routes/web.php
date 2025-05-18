<?php

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
Route::prefix('admin')->group(function () {
    Route::get('/posts/create', [App\Http\Controllers\AdminControllers\AdminPostControllers::class, 'create'])->name('admin.posts.create');
    Route::post('/posts', [App\Http\Controllers\AdminControllers\AdminPostControllers::class, 'store'])->name('admin.posts.store');
});


Route::get('/', function () {
    return view('welcome');
});
