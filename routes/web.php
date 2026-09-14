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

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/choose-path', function () {
    return view('choose-path');
})->name('choose-path');

/*
|--------------------------------------------------------------------------
| Career Path
|--------------------------------------------------------------------------
*/

Route::get('/jobs/dashboard', function () {
    return view('jobs.dashboard');
})->name('jobs.dashboard');