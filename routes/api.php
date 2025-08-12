<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;



Route::prefix('posts')->group(function () {
    Route::get('list', [PostController::class, 'getAll']);
    Route::get('/{id}/detail', [PostController::class, 'getById']);
    Route::post('create', [PostController::class, 'create']);
    Route::patch('{id}/update', [PostController::class, 'update']);
    Route::delete('{id}/delete', [PostController::class, 'deleted']);
    Route::get('author/{userId}', [PostController::class, 'getByAllUserId']);
})->middleware('auth');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

use Illuminate\Support\Facades\Cache;

Route::get('/cache-test', function () {
    $page=1;
    $cachedPost=Cache::get("List-:$page");
    $id = 7;
//    $cachedPost =Cache::get("post:{$id}");
    return $cachedPost;
});

Route::get('Singleton', [\App\Http\Controllers\SingletonLoggerController::class, 'logTest']);





