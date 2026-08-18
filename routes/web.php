<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    Route::resource('donors', DonorController::class)->except(['destroy']);
    Route::delete('donors/{donor}', [DonorController::class, 'destroy'])
        ->middleware('admin')
        ->name('donors.destroy');

    Route::resource('deductions', DeductionController::class);
    Route::patch('deductions/{deduction}/confirm-payment', [DeductionController::class, 'confirmPayment'])
        ->name('deductions.confirm-payment');
    Route::post('deductions/{id}/confirm-payment', [DeductionController::class, 'confirmPayment'])
        ->name('deductions.confirm-payment.post');
});

require __DIR__.'/auth.php';
