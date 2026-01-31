<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TreatmentNoteController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/', function () {

    return view('welcome');

});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patients
    Route::middleware('role:admin,receptionist')->group(function () {
        Route::resource('patients', PatientController::class);
    });

    // Appointments
    Route::middleware('role:admin,receptionist,dentist,patient')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    });

    Route::middleware('role:admin,receptionist')->group(function () {
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
        Route::post('/appointments/{appointment}/confirm', [
            AppointmentController::class,
            'confirm'
        ])->name('appointments.confirm');
        Route::post('/appointments/{appointment}/cancel', [
            AppointmentController::class,
            'cancel'
        ])->name('appointments.cancel');
    });

    Route::middleware('role:dentist')->group(function () {
        Route::post('/appointments/{appointment}/status', [
            AppointmentController::class,
            'updateStatus'
        ])->name('appointments.update-status');
    });

    // Treatment Notes
    Route::middleware('role:admin,dentist,receptionist,patient')->group(function () {
        Route::get('/treatment-notes', [TreatmentNoteController::class, 'index'])->name('treatment-notes.index');
        Route::get('/treatment-notes/{treatmentNote}', [TreatmentNoteController::class, 'show'])->name('treatment-notes.show');
    });

    Route::middleware('role:admin,dentist')->group(function () {
        Route::get('/treatment-notes/create', [TreatmentNoteController::class, 'create'])->name('treatment-notes.create');
        Route::post('/treatment-notes', [TreatmentNoteController::class, 'store'])->name('treatment-notes.store');
        Route::get('/treatment-notes/{treatmentNote}/edit', [
            TreatmentNoteController::class,
            'edit'
        ])->name('treatment-notes.edit');
        Route::put('/treatment-notes/{treatmentNote}', [
            TreatmentNoteController::class,
            'update'
        ])->name('treatment-notes.update');
        Route::delete('/treatment-notes/{treatmentNote}', [
            TreatmentNoteController::class,
            'destroy'
        ])->name('treatment-notes.destroy');
    });

    Route::middleware('role:admin,receptionist')->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

require __DIR__ . '/auth.php';