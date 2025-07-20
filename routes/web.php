<?php

use Illuminate\Support\Facades\Route;
use \App\Livewire\Chat;

Route::get('/', function () {
    return view('page.home');
})->name('home');

Route::get('/chat', Chat::class)->name('chat');

Route::get('/mood', function () {
    return view('page.mood_detector');
});

Route::get('/calmzone', function () {
    return view('page.calm_zone');
});

Route::get('/virtualpet', function () {
    return view('page.virtual_pet');
});

Route::get('/dashboard', function () {
    return view('page.dashboard');
});

Route::get('/community', function () {
    return view('page.community');
});