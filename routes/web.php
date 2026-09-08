<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/profile', function () {
    return view('profile');
})->name('profile');
Route::get('/cv-upload', function () {
    return view('cv-upload');
})->name('cv-upload'); 

