<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index']); // Obtención de los datos de todos los Posts
Route::get('/posts/{id}', [PostController::class, 'show']);