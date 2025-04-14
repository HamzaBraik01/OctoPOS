<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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
// Routes publiques
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Routes protégées par rôle
Route::middleware('auth:api')->group(function () {
    Route::get('/proprietaires/dashboard', function () {
        return view('proprietaires.dashboard');
    })->middleware('role:Propriétaires');

    Route::get('/gerants/dashboard', function () {
        return view('gerants.dashboard');
    })->middleware('role:Gérants');

    Route::get('/serveurs/dashboard', function () {
        return view('serveurs.dashboard');
    })->middleware('role:Serveurs');

    Route::get('/cuisiniers/dashboard', function () {
        return view('cuisiniers.dashboard');
    })->middleware('role:Cuisiniers');

    Route::get('/clients/dashboard', function () {
        return view('clients.dashboard');
    })->middleware('role:Clients');
});