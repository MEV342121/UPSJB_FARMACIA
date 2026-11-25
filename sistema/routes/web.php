<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::resource('categories', CategoryController::class)->except('show');
Route::resource('medicines', MedicineController::class)->except('show');
Route::resource('customers', CustomerController::class)->except('show');
Route::resource('sales', SaleController::class)->except(['edit', 'update']);
Route::resource('roles', RoleController::class)->except('show');
Route::resource('users', UserController::class)->except('show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('medicines', MedicineController::class)->except('show');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('sales', SaleController::class)->except(['edit', 'update']);
    Route::resource('roles', RoleController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('role:Administrador,Químico farmacéutico')->group(function () {
        Route::resource('suppliers', SupplierController::class)->except('show');
    });
});
