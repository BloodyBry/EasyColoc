<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Colocations
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
    Route::post('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
    Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocations.leave');

    // Categories
    Route::get('/colocations/{colocation}/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/colocations/{colocation}/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Expenses
    Route::get('/colocations/{colocation}/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/colocations/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/colocations/{colocation}/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    // Invitations
    Route::get('/colocations/{colocation}/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::post('/colocations/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/invite/{token}', [InvitationController::class, 'acceptForm'])->name('invitations.acceptForm');
    Route::post('/invite/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');

    // Balances + Payments
    Route::get('/colocations/{colocation}/balances', [ColocationController::class, 'balances'])->name('colocations.balances');
    Route::post('/colocations/{colocation}/payments', [PaymentController::class, 'store'])->name('payments.store');

    // Admin (check dans AdminController)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');
});

require __DIR__ . '/auth.php';