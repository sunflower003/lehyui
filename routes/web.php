<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminControllers\AdminPostControllers;
use App\Http\Controllers\AdminControllers\DashboardControllers;

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

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');





Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'check_permissions'])
    ->group(function () {

    // Dashboard
    Route::get('/', [DashboardControllers::class, 'index'])->name('dashboard');

    // Bài viết
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [AdminPostControllers::class, 'index'])->name('index');
        Route::get('/create', [AdminPostControllers::class, 'create'])->name('create');
        Route::post('/store', [AdminPostControllers::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminPostControllers::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AdminPostControllers::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminPostControllers::class, 'destroy'])->name('destroy');
    });

    // Các nhóm route khác như categories, users,... bạn khai báo tương tự
});
