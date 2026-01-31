<?php

use App\Http\Controllers\LandController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Land Routes
    Route::get('/map', [LandController::class, 'map'])->name('lands.map');
    Route::get('/lands/{land}', [LandController::class, 'show'])->name('lands.show');
});

require __DIR__.'/auth.php';
