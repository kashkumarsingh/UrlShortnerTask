<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortnerController;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the URL Shortener API']);
});

Route::post('/encode', [UrlShortnerController::class, 'encode']);
Route::post('/decode', [UrlShortnerController::class, 'decode']);