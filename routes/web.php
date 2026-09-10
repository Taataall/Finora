<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('finora.index')
        : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');
    Route::get('/finora', [TransactionController::class, 'index'])->name('finora.index');

    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('finora.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');

    Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
