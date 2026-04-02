<?php

use App\Http\Controllers\AdminWalletController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected
Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Wallet
    Route::get('/wallet', [WalletController::class, 'index']);
    Route::post('/wallet/spend', [WalletController::class, 'spend']);

    // Admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::post('/wallet/{user}/credit', [AdminWalletController::class, 'credit']);
        Route::post('/wallet/{user}/debit', [AdminWalletController::class, 'debit']);
    });
});
