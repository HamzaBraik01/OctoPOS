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
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CommandePlatController;
use App\Http\Controllers\ProprietaireController;

Route::get('/', [HomeController::class, 'index'])->name('home');

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

    Route::prefix('gerant')->middleware('role:gérant')->group(function () {
        Route::get('/dashboard', [GerantController::class, 'dashboard'])->name('gerant.dashboard');
        Route::get('/reservations', [GerantController::class, 'reservations'])->name('gerant.reservations');
        
        Route::get('/get-reservations', [GerantController::class, 'getReservations'])->name('gerant.getReservations');
        Route::post('/reservations/update-status', [GerantController::class, 'updateStatus'])->name('gerant.reservations.updateStatus');
        
        Route::get('/get-recent-transactions', [GerantController::class, 'getRecentTransactions'])->name('gerant.getRecentTransactions');
        
        Route::get('/get-sales-summary', [GerantController::class, 'getSalesSummary'])->name('gerant.getSalesSummary');
        Route::get('/get-sales-performance', [GerantController::class, 'getSalesPerformance'])->name('gerant.getSalesPerformance');
        
        Route::post('/tables/update-status', [TableController::class, 'updateStatus'])->name('gerant.tables.updateStatus');
        
        Route::post('/commandes/update-status', [CommandeController::class, 'updateStatus'])->name('gerant.commandes.updateStatus');
        
        Route::delete('/personnel/{id}', [UtilisateurController::class, 'destroy'])->name('gerant.personnel.destroy');
        Route::get('/personnel/{id}/edit', [UtilisateurController::class, 'edit'])->name('gerant.personnel.edit');
        Route::post('/personnel/update-role', [UtilisateurController::class, 'updateRole'])->name('gerant.personnel.updateRole');
        
        Route::get('/users', [GerantController::class, 'getUsers'])->name('gerant.users');
        Route::post('/users/update-role', [GerantController::class, 'updateUserRole'])->name('gerant.users.updateRole');
        Route::delete('/users/{id}', [GerantController::class, 'deleteUser'])->name('gerant.users.delete');
        Route::get('/users/delete-redirect/{id}', [GerantController::class, 'deleteUserRedirect'])->name('gerant.users.delete-redirect');
        
        Route::post('/horaires', [GerantController::class, 'storeHoraire'])->name('gerant.horaires.store');
        
        Route::get('/menus/by-restaurant/{restaurantId}', [GerantController::class, 'getMenusByRestaurant'])->name('gerant.menus.byRestaurant');
        Route::post('/menus/store', [GerantController::class, 'storeMenu'])->name('gerant.menus.store');
        Route::put('/menus/update/{id}', [GerantController::class, 'updateMenu'])->name('gerant.menus.update');
        Route::delete('/menus/delete/{id}', [GerantController::class, 'deleteMenu'])->name('gerant.menus.delete');
        Route::post('/menus/supprimer/{id}', [GerantController::class, 'supprimerMenu'])->name('gerant.menus.supprimer');
        
        Route::get('/plats/by-menu/{menuId}', [GerantController::class, 'getPlatsByMenu'])->name('gerant.plats.byMenu');
        Route::get('/plats/by-restaurant/{restaurantId}', [GerantController::class, 'getPlatsByRestaurant'])->name('gerant.plats.byRestaurant');
        Route::post('/plats/store', [GerantController::class, 'storePlat'])->name('gerant.plats.store');
        Route::put('/plats/update/{id}', [GerantController::class, 'updatePlat'])->name('gerant.plats.update');
        Route::delete('/plats/delete/{id}', [GerantController::class, 'deletePlat'])->name('gerant.plats.delete');
        Route::post('/plats/supprimer/{id}', [GerantController::class, 'supprimerPlat'])->name('gerant.plats.supprimer');

        // Routes pour les tables
        Route::get('/get-tables', [GerantController::class, 'getTables'])->name('gerant.getTables');
        Route::post('/tables', [GerantController::class, 'storeTable'])->name('gerant.storeTable');
        Route::put('/tables/{id}', [GerantController::class, 'updateTable'])->name('gerant.updateTable');
        Route::delete('/tables/{id}', [GerantController::class, 'deleteTable'])->name('gerant.deleteTable');
        Route::post('/tables/{id}/update-status', [GerantController::class, 'updateTableStatus'])->name('gerant.updateTableStatus');
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
    
    Route::post('/restaurants/set-restaurant', [RestaurantController::class, 'setRestaurant']);
    Route::get('/restaurants/{restaurantId}/tables', [ServeurController::class, 'getRestaurantTables']);
    
    Route::post('/serveur/select-restaurant', [ServeurController::class, 'selectRestaurant'])->name('serveur.select-restaurant');
    Route::get('/serveur/filtrer-plats', [ServeurController::class, 'filtrerPlats'])->name('serveur.filtrer-plats');
});

Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
Route::post('/commande-plats', [CommandePlatController::class, 'store'])->name('commande-plats.store');
