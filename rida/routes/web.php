<?php

use Illuminate\Support\Facades\Route;
use App\Models\Land;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\PurchaseController;

// ✅ Admin Controllers (المكان الصح)
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLandController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPurchaseController;

// ✅ الصفحة الرئيسية
Route::get('/', function () {
    if (auth()->check()) {
        $lands = Land::where('is_for_sale', true)->latest()->get();
        $focus = request('land_id');
        return view('welcome', compact('lands', 'focus'));
    }

    return view('landing');
});

Route::get('/welcome', function () {
    $lands = Land::where('is_for_sale', true)->latest()->get();
    $focus = request('land_id');
    return view('welcome', compact('lands', 'focus'));
})->name('welcome');

// routes/web.php
Route::get('/map', function () {
    $lands = \App\Models\Land::where('is_for_sale', true)->get();
    return view('map.index', compact('lands'));
})->middleware('auth')->name('map');




/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Redirect orphan URLs (only admin can create/edit lands)
    Route::get('lands/create', fn () => redirect()->route('lands.index'))->name('lands.create');
    Route::get('lands/{land}/edit', fn () => redirect()->route('lands.index'))->name('lands.edit');

    // List & View Lands (user: index & show only)
    Route::resource('lands', LandController::class)->only(['index', 'show']);

    // Fake Checkout (الدفع الوهمي)
    Route::get('/checkout/{land}', [PurchaseController::class, 'checkout'])
        ->name('checkout.show');

    Route::post('/checkout/{land}', [PurchaseController::class, 'payFake'])
        ->name('checkout.pay');

    // Purchases & Sales
    Route::get('/purchases', [PurchaseController::class, 'myPurchases'])
        ->name('purchases.index');

    Route::get('/sales', [PurchaseController::class, 'mySales'])
        ->name('sales.index');

    // Wallet System
    Route::get('/wallet', [\App\Http\Controllers\WalletController::class, 'index'])
        ->name('wallet.index');
    Route::post('/wallet/top-up', [\App\Http\Controllers\WalletController::class, 'topUp'])
        ->name('wallet.topup');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ✅ Admin Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ✅ Admin Lands
        Route::get('/lands', [AdminLandController::class, 'index'])
            ->name('lands.index');

        Route::get('/lands/create', [AdminLandController::class, 'create'])
            ->name('lands.create');

        Route::post('/lands', [AdminLandController::class, 'store'])
            ->name('lands.store');

        Route::get('/lands/{land}/edit', [AdminLandController::class, 'edit'])
            ->name('lands.edit');

        Route::put('/lands/{land}', [AdminLandController::class, 'update'])
            ->name('lands.update');

        Route::delete('/lands/{land}', [AdminLandController::class, 'destroy'])
            ->name('lands.destroy');

        // ✅ Admin Users
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])
            ->name('users.toggleAdmin');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

        // ✅ Admin Purchases
        Route::get('/purchases', [AdminPurchaseController::class, 'index'])
            ->name('purchases.index');
    });

require __DIR__ . '/auth.php';
