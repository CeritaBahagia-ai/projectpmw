<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page.home');
});

Route::get('/chat', function () {
    return view('page.chat');
});

Route::get('/mood', function () {
    return view('page.mood_detector');
});

Route::get('/dashboard', function () {
    return view('page.dashboard');
});

Route::get('/community', function () {
    return view('page.community');
});