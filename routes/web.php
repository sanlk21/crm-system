<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/get/data', [CustomerController::class, 'getData'])->name('customers.getdata');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/edit/{customer}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/update/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::put('/customers/status-update', [CustomerController::class, 'updateStatus'])->name('customers.status.update');
    Route::delete('/customers/delete/{customer}', [CustomerController::class, 'destroy'])->name('customers.delete');
    Route::get('/customers/show/{customer}', [CustomerController::class, 'show'])->name('customers.show');

    // Proposal routes
    Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals.index');
    Route::get('/proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
    Route::post('/proposals/store', [ProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/edit/{proposal}', [ProposalController::class, 'edit'])->name('proposals.edit');
    Route::put('/proposals/update/{proposal}', [ProposalController::class, 'update'])->name('proposals.update');
    Route::put('/proposals/status-update/{proposal}', [ProposalController::class, 'updateStatus'])->name('proposals.status.update');
    Route::delete('/proposals/delete/{proposal}', [ProposalController::class, 'destroy'])->name('proposals.delete');
    Route::get('/proposals/show/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');

    // Invoice routes
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/show/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/edit/{invoice}', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/update/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::put('/invoices/status-update/{invoice}', [InvoiceController::class, 'updateStatus'])->name('invoices.status.update');
    Route::delete('/invoices/delete/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.delete');

    // Transaction routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/show/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/edit/{transaction}', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/update/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::put('/transactions/status-update/{transaction}', [TransactionController::class, 'updateStatus'])->name('transactions.status.update');
    Route::delete('/transactions/delete/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.delete');
});

require __DIR__.'/auth.php';
