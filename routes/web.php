<?php


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Route::get('/send-bot', function () {
//    $token = '8316739639:AAGujqZxMxHKea_b8xnwM51uvLojkH09lLc';
//    $chatId = '-1002810873390';
//    $text ='salam';
//    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=$text";
//    return $url;
//});
// routes/web.php

// Route::get("/api/post/{id}", [PostController::class,"show"])->name("posts.show");
// http://127.0.0.1:8000/api/post/list
// Route::get("/api/post/list", [PostController::class,"index"])->name("posts.index");

