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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// ✅ الصفحة الرئيسية
Route::get('/', function () {
    if (auth()->check()) {
        $lands = Land::where('is_for_sale', true)->latest()->get();
        $focus = request('land_id');
        return view('welcome', compact('lands', 'focus'));
    }

    return view('landing');
});

// ✅ Preview Map للزوار
Route::get('/map', function () {
    $lands = Land::where('is_for_sale', true)->latest()->get();
    $focus = request('land_id');
    return view('welcome', compact('lands', 'focus'));
});

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

    // CRUD Lands (لليوزر)
    Route::resource('lands', LandController::class);

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

        // ✅ Admin Purchases
        Route::get('/purchases', [AdminPurchaseController::class, 'index'])
            ->name('purchases.index');
    });

require __DIR__.'/auth.php';
