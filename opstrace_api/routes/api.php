<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MonitoredProductController;
use App\Http\Controllers\PriceHistoryController;
use App\Http\Controllers\Telegram\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('telegram')->group(function () {
    Route::post('/webhook', [TelegramController::class, 'handle']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/set-webhook', [TelegramController::class, 'setWebhook']);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [MeController::class, 'me']);
        Route::put('/edit-me', [MeController::class, 'editMeInfo']);
        Route::post('/logout', [LogoutController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/monitored-products', [MonitoredProductController::class, 'index']);
    Route::post('/monitored-product', [MonitoredProductController::class, 'store']);
    Route::put('/monitored-product/{monitoredProduct}', [MonitoredProductController::class, 'update']);
    Route::delete('/monitored-product/{monitoredProduct}', [MonitoredProductController::class, 'destroy']);

    Route::get('/price-histories', [PriceHistoryController::class, 'index']);
    Route::post('/monitoring-results', [PriceHistoryController::class, 'store']);
});
