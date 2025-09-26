<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// SPA fallback: send all non-API routes to the Vue app
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');

