<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Usuario
Route::get('/configuracion', [UserController::class, 'config'])->name('user.config');
Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename}', [UserController::class, 'getImage'])->name('user.avatar');
Route::get('/perfil/{id}', [UserController::class, 'profile'])->name('user.profile');
Route::get('/usuarios/{search?}', [UserController::class, 'index'])->name('user.index');

// Imagen
Route::get('/subir-imagen', [ImageController::class, 'create'])->name('image.create');
Route::post('/image-save', [ImageController::class, 'save'])->name('image.save');
Route::get('/image/file/{filename}', [ImageController::class, 'getImage'])->name('image.file');
Route::get('/image/{id}', [ImageController::class, 'detail'])->name('image.detail');
Route::get('/imagen/delete/{id}', [ImageController::class, 'delete'])->name('image.delete');
Route::get('/image/editar/{id}', [ImageController::class, 'edit'])->name('image.edit');
Route::post('/image/update', [ImageController::class, 'update'])->name('image.update');

// Comentarios
Route::post('/comment/save', [CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');

// Likes
Route::get('/like/{image_id}', [LikeController::class, 'like'])->name('like.save');
Route::get('/dislike/{image_id}', [LikeController::class, 'dislike'])->name('like.delete');
Route::get('/likes', [LikeController::class, 'index'])->name('likes');



