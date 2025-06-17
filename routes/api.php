<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Importujemy kontrolery, których będziemy używać
use App\Http\Controllers\Api\KlientController;
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

    // Endpointy do zarządzania zasobem "Klienci"
    Route::apiResource('klienci', KlientController::class);
    
});