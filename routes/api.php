<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::Resource('post','App\Http\Controllers\PostController');
// Route::Resource('add-user','App\Http\Controllers\UserController');


Route::prefix('posts')->group(function () {
    Route::get('list', [PostController::class,'getAll']);
    Route::get('/{id}/detail', [PostController::class,'getById']);
    Route::post('create', [PostController::class,'create']);
    Route::patch('{id}/update', [PostController::class,'update']);
    Route::delete('{id}/delete', [PostController::class,'delete']);

})->middleware('auth');

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login'])->name('login.post');
Route::post('logout', [AuthController::class,'logout'])->name('logout')->middleware('auth:sanctum');

Route::get('/log-test', function () {
    Log::channel('telegram')->error('ERROR IN TELEGRAM');

});




