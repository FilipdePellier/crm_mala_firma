<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\KlientController;
use App\Http\Controllers\Api\KontaktController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\NotatkaController;
use App\Http\Controllers\Api\SzanseSprzedazyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Session\Middleware\StartSession; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest', StartSession::class]) 
    ->name('login');



Route::middleware('auth:sanctum')->group(function () {
    
    // Endpoint do wylogowania (unieważnia token)
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware(StartSession::class) 
        ->name('logout');

    // Endpoint do pobrania danych zalogowanego użytkownika
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('klienci', KlientController::class);
    Route::apiResource('kontakty', KontaktController::class);
    Route::apiResource('leady', LeadController::class);
    Route::apiResource('szanse-sprzedazy', SzanseSprzedazyController::class);
    Route::apiResource('notatki', NotatkaController::class);
    
});