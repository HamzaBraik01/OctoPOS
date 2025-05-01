<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\HoraireController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GerantController;
use App\Http\Middleware\JWTAuthentication;
use App\Http\Controllers\ServeurController;
use App\Http\Controllers\CuisinierController;
use App\Http\Controllers\ReservationController;
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
    
    // Gérant routes
    Route::get('/gerants/dashboard', [GerantController::class, 'index'])
        ->middleware('role:gérant')
        ->name('gerants.dashboard');

    // Gérant section routes - handled via AJAX or direct access
    Route::prefix('gerant')->middleware('role:gérant')->group(function () {
        Route::get('/dashboard', [GerantController::class, 'dashboard'])->name('gerant.dashboard');
        Route::get('/reservations', [GerantController::class, 'reservations'])->name('gerant.reservations');
        
        // API endpoints for restaurant reservations
        Route::get('/get-reservations', [GerantController::class, 'getReservations'])->name('gerant.getReservations');
        Route::post('/reservations/update-status', [GerantController::class, 'updateStatus'])->name('gerant.reservations.updateStatus');

        // Routes pour les tables
        Route::post('/tables/update-status', [TableController::class, 'updateStatus'])->name('gerant.tables.updateStatus');
        
        // Routes pour les commandes
        Route::post('/commandes/update-status', [CommandeController::class, 'updateStatus'])->name('gerant.commandes.updateStatus');
        
        // Routes pour le personnel (via UtilisateurController)
        Route::delete('/personnel/{id}', [UtilisateurController::class, 'destroy'])->name('gerant.personnel.destroy');
        Route::get('/personnel/{id}/edit', [UtilisateurController::class, 'edit'])->name('gerant.personnel.edit');
        Route::post('/personnel/update-role', [UtilisateurController::class, 'updateRole'])->name('gerant.personnel.updateRole');
        
        // Routes pour les horaires
        Route::post('/horaires', [GerantController::class, 'storeHoraire'])->name('gerant.horaires.store');
    });

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
});
