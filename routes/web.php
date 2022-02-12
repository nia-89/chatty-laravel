<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'App\Http\Controllers\UploadFileController@uploadForm');
Route::post('/', 'App\Http\Controllers\UploadFileController@upload');

Route::get('/chats', 'App\Http\Controllers\ChatsController@index');
Route::get('/chat/{id}','App\Http\Controllers\ChatsController@show');

