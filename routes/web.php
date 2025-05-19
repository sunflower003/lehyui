<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminControllers\AdminPostControllers;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/category/{id}', [PostController::class, 'byCategory'])->name('category.posts');

// Trang settings
Route::get('/profile/settings', [UserController::class, 'settings'])->name('profile.settings');

// Cập nhật username & avatar
Route::post('/profile/update-info', [UserController::class, 'updateInfo'])->name('profile.update.info');

// Cập nhật mật khẩu
Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.update.password');

// Xoá tài khoản
Route::delete('/profile/delete', [UserController::class, 'deleteAccount'])->name('profile.delete.account');




Route::prefix('admin/posts')->group(function () {
    Route::get('/', [AdminPostControllers::class, 'index'])->name('admin.posts.index');
    Route::get('/create', [AdminPostControllers::class, 'create'])->name('admin.posts.create');
    Route::post('/store', [AdminPostControllers::class, 'store'])->name('admin.posts.store');
    Route::get('/edit/{id}', [AdminPostControllers::class, 'edit'])->name('admin.posts.edit');
    Route::post('/update/{id}', [AdminPostControllers::class, 'update'])->name('admin.posts.update');
    Route::delete('/delete/{id}', [AdminPostControllers::class, 'destroy'])->name('admin.posts.destroy');
});