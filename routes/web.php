<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TableController;


use App\Http\Controllers\ClientController;
use App\Http\Controllers\GerantController;
use App\Http\Middleware\JWTAuthentication;
use App\Http\Controllers\ServeurController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CuisinierController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CommandePlatController;
use App\Http\Controllers\ProprietaireController;

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
    Route::get('/proprietaires/dashboard', [ProprietaireController::class, 'index'])
        ->middleware('role:propriétaire')
        ->name('proprietaires.dashboard'); 
        Route::get('/available-time-slots', 'ReservationController@getAvailableTimeSlots')->middleware('role:propriétaire')
        ->name('reservations.available-times');
    Route::get('/gerants/dashboard', [GerantController::class, 'index'])
        ->middleware('role:gérant')
        ->name('gerants.dashboard');

    Route::get('/serveurs/dashboard', [ServeurController::class, 'index'])
        ->middleware('role:serveur')
        ->name('serveurs.dashboard');

    Route::get('/cuisiniers/dashboard', [CuisinierController::class, 'index'])
        ->middleware('role:cuisinier')
        ->name('cuisiniers.dashboard');

    Route::get('/clients/dashboard', [ClientController::class, 'index'])
        ->middleware('role:client')
        ->name('clients.dashboard');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/clients/reservations-receipt/{id}', [ReservationController::class, 'receipt'])->name('clients.reservations-receipt');
Route::post('/restaurants/set-restaurant', [RestaurantController::class, 'setRestaurant']);
Route::get('/restaurants/{restaurantId}/tables', [ServeurController::class, 'getRestaurantTables']);
Route::post('/serveur/select-restaurant', [ServeurController::class, 'selectRestaurant'])->name('serveur.select-restaurant');
Route::get('/serveur/filtrer-plats', [ServeurController::class, 'filtrerPlats'])->name('serveur.filtrer-plats');
});

// Routes pour les commandes
Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
Route::post('/commande-plats', [CommandePlatController::class, 'store'])->name('commande-plats.store');
