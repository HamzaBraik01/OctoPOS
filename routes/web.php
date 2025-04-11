<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');

/*// Routes d'authentification
Auth::routes();

// Routes POS
Route::prefix('pos')->group(function () {
    Route::get('/server', function () {
        return view('pos.server');
    })->name('pos.server');

    Route::get('/kitchen', function () {
        return view('pos.kitchen');
    })->name('pos.kitchen');

    Route::get('/manager', function () {
        return view('pos.manager');
    })->name('pos.manager');

    Route::get('/admin', function () {
        return view('pos.admin');
    })->name('pos.admin');
});
*/