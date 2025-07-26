<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Master
use App\Http\Controllers\UserController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\ZakatTransactionController;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () {
	Route::post('logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile/ganti-password/{id}', [ProfileController::class, 'changePassword'])->name('profile.ganti-password');
    Route::put('profile/update-profile/{id}', [ProfileController::class, 'updateProfile'])->name('profile.update-profile');

	// User
	Route::prefix('users')->name('users.')->group(function () {
		Route::match(['get', 'post'], '/', [UserController::class, 'index'])->name('index');
		Route::get('create', [UserController::class, 'create'])->name('create');
		Route::post('store', [UserController::class, 'store'])->name('store');
		Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
		Route::put('{user}', [UserController::class, 'update'])->name('update');
		Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
	});

	// Muzakki
	Route::prefix('muzakkis')->name('muzakkis.')->group(function () {
		Route::match(['get', 'post'], '/', [MuzakkiController::class, 'index'])->name('index');
		Route::get('create', [MuzakkiController::class, 'create'])->name('create');
		Route::post('store', [MuzakkiController::class, 'store'])->name('store');
		Route::get('{muzakki}/edit', [MuzakkiController::class, 'edit'])->name('edit');
		Route::put('{muzakki}', [MuzakkiController::class, 'update'])->name('update');
		Route::delete('{muzakki}', [MuzakkiController::class, 'destroy'])->name('destroy');
	});

	// Mustahik
	Route::prefix('mustahiks')->name('mustahiks.')->group(function () {
		Route::match(['get', 'post'], '/', [MustahikController::class, 'index'])->name('index');
		Route::get('create', [MustahikController::class, 'create'])->name('create');
		Route::post('store', [MustahikController::class, 'store'])->name('store');
		Route::get('{mustahik}/edit', [MustahikController::class, 'edit'])->name('edit');
		Route::put('{mustahik}', [MustahikController::class, 'update'])->name('update');
		Route::delete('{mustahik}', [MustahikController::class, 'destroy'])->name('destroy');
	});

	// Zakat Transactions
	Route::prefix('zakat-transactions')->name('zakat-transactions.')->group(function () {
		Route::match(['get', 'post'], '/', [ZakatTransactionController::class, 'index'])->name('index');
		Route::get('create', [ZakatTransactionController::class, 'create'])->name('create');
		Route::post('store', [ZakatTransactionController::class, 'store'])->name('store');
		Route::get('{transaction}/edit', [ZakatTransactionController::class, 'edit'])->name('edit');
		Route::put('{transaction}', [ZakatTransactionController::class, 'update'])->name('update');
		Route::delete('{transaction}', [ZakatTransactionController::class, 'destroy'])->name('destroy');
	});
});