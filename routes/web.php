<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/', [AssetController::class, 'index'])->name('assets.index');

    Route::post('/assets/sync', [AssetController::class, 'sync'])->name('assets.sync');

    Route::get('/assets/{asset}', [AssetController::class, 'show'])->name('assets.show');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');

    Route::get('/alerts/create', [AlertController::class, 'create'])->name('alerts.create');

    Route::post('/alerts/create', [AlertController::class, 'store'])->name('alerts.store');

    Route::get('/alerts/{alert}/edit', [AlertController::class, 'edit'])->name('alerts.edit');

    Route::put('/alerts/{alert}', [AlertController::class, 'update'])->name('alerts.update');

    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy'])->name('alerts.destroy');

});
