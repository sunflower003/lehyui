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
use Illuminate\Support\Facades\Log;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Quên mật khẩu
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email');
Route::get('/reset-password/code', [AuthController::class, 'showCodeForm'])->name('password.code');
Route::post('/reset-password/verify', [AuthController::class, 'verifyCode'])->name('password.verify');
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/donate/pay', [DonateController::class, 'redirectToNode'])->name('donate.redirect');
Route::get('/donate/return', [DonateController::class, 'handleReturn'])->name('donate.callback');
Route::post('/donate/webhook', [DonateController::class, 'webhookPayOS'])->name('donate.webhook');
Route::post('/testwebhook', function(\Illuminate\Http\Request $req) {
    Log::info('Test webhook ok', $req->all());
    return response()->json(['ok' => true]);
});



Route::get('/category/{id}', [PostController::class, 'byCategory'])->name('category.posts');

Route::middleware(['auth'])->get('/profile/settings', [UserController::class, 'settings'])->name('profile.settings');

// Trang settings
Route::get('/profile/settings', [UserController::class, 'settings'])->name('profile.settings');

// Cập nhật username & avatar
Route::post('/profile/update-info', [UserController::class, 'updateInfo'])->name('profile.update.info');

// Cập nhật mật khẩu
Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.update.password');

// Xoá tài khoản
Route::delete('/profile/delete', [UserController::class, 'deleteAccount'])->name('profile.delete.account');
// Route bình luận – CHO NGƯỜI DÙNG (KHÔNG PHẢI ADMIN)
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Route Like/Dislike cho bình luận
    Route::post('/comments/{id}/like', [App\Http\Controllers\CommentLikeController::class, 'like'])->name('comments.like');
    Route::post('/comments/{id}/dislike', [App\Http\Controllers\CommentLikeController::class, 'dislike'])->name('comments.dislike');
});

 
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories', [CategoryController::class, 'showAllCategories'])->name('categories.all');



Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');

Route::middleware('auth')->post('/comments', [CommentController::class, 'store'])->name('comments.store');



Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::post('/testlog', function (\Illuminate\Http\Request $request) {
    Log::info('TestLog:', $request->all());
    return ['ok' => true];
});



Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'check_permissions'])
    ->group(function () {

    // Dashboard
    Route::get('/', [DashboardControllers::class, 'index'])->name('dashboard');
    Route::get('/chart/comments', [DashboardControllers::class, 'getCommentChartData']);

    Route::get('/donations', [DonateController::class, 'adminIndex'])->name('donations.index');

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

