<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Master
use App\Http\Controllers\UserController;


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
});