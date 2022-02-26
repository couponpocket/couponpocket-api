<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'app')->name('app');

// email is sending an url for it:
Route::get('/reset-password', function () {
    return redirect('/#/reset-password');
})->name('password.reset');

// email is sending an url for it:
Route::get('/login', function () {
    return redirect('/#/login');
})->name('login');
