<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    return 'test ';
});

// Route::get("/api/post/{id}", [PostController::class,"show"])->name("posts.show");
// http://127.0.0.1:8000/api/post/list
// Route::get("/api/post/list", [PostController::class,"index"])->name("posts.index");
