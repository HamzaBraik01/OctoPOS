<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\HomeController;


use App\Http\Middleware\JWTAuthentication;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


// Routes publiques
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([JWTAuthentication::class])->group(function () {
    Route::get('/proprietaires/dashboard', function () {
        return view('proprietaires.dashboard');
    })->middleware('role:propriétaire')->name('proprietaires.dashboard');

    Route::get('/gerants/dashboard', function () {
        return view('gerants.dashboard');
    })->middleware('role:gérant')->name('gerants.dashboard');

    Route::get('/serveurs/dashboard', function () {
        return view('serveurs.dashboard');
    })->middleware('role:serveur')->name('serveurs.dashboard');

    Route::get('/cuisiniers/dashboard', function () {
        return view('cuisiniers.dashboard');
    })->middleware('role:cuisinier')->name('cuisiniers.dashboard');

    Route::get('/clients/dashboard', function () {
        return view('clients.dashboard');
    })->middleware('role:client')->name('clients.dashboard');
});