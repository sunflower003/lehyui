<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\AdminControllers\AdminPostControllers;
use App\Http\Controllers\AdminControllers\DashboardControllers;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/donate/pay', [DonateController::class, 'redirectToNode'])->name('donate.redirect');
Route::get('/donate/return', [DonateController::class, 'handleReturn'])->name('donate.callback');

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

Route::get('/categories', [CategoryController::class, 'showAllCategories'])->name('categories.all');



Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');

Route::middleware('auth')->post('/comments', [CommentController::class, 'store'])->name('comments.store');



Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');





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

    // User 
    Route::prefix('users')->name('users.')->middleware(['is_admin'])->group(function () {
        Route::get('/', [UserController::class, 'adminIndex'])->name('index');
        Route::get('/{user}/edit', [UserController::class, 'adminEdit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'adminUpdate'])->name('update');
        Route::delete('/{user}', [UserController::class, 'adminDestroy'])->name('destroy');
    });
    
 Route::prefix('categories')->name('categories.')->middleware(['is_admin'])->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    // Các nhóm route khác như categories, users,... bạn khai báo tương tự
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/delete/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


});

