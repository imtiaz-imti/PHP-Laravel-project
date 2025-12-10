<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;

Route::get('/', [AppController::class, 'app_operation']);

Route::get('/sign-in', [AuthController::class, 'signin']);
Route::get('/sign-up', [AuthController::class, 'signup']);
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/details-save', [AppController::class, 'save_details'])->name('save-details');
Route::get('/search/user', [AppController::class, 'search_user'])->name('search_user');
Route::post('/upload/image', [AppController::class, 'upload_image'])->name('upload_image');
Route::post('/user/follow/{id}', [AppController::class, 'user_follow'])->name('user_follow');
Route::post('/user/unfollow_remove/{id}', [AppController::class, 'user_unfollow_remove'])->name('user_unfollow_remove');
Route::get('/profile/details/{id}', [AppController::class, 'profile_details']);
Route::get('/image/details/{id}', [AppController::class, 'image_details'])->name('image.details');
Route::get('/image/like/{id}', [AppController::class, 'image_like'])->name('image.like');
Route::post('/user/comment/{imageID}/{commentID?}', [AppController::class, 'user_comment'])->name('user.comment');
Route::get('/comment/like/{id}/{imageID}', [AppController::class, 'comment_like']);
Route::get('/comment/details/{id}/{imageID}', [AppController::class, 'comment_details']);

