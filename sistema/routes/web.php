<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ── Solo para visitantes (sin sesión): el login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ── Solo para usuarios con sesión iniciada
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Todos los roles
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('sales', SaleController::class)->except(['edit', 'update'])
        ->middlewareFor('destroy', 'role:Administrador'); // solo el administrador anula ventas

    // Administrador y Químico farmacéutico
    Route::middleware('role:Administrador,Químico farmacéutico')->group(function () {
        Route::resource('medicines', MedicineController::class)->except('show');
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
        Route::get('/reports/sales/excel', [ReportController::class, 'salesExcel'])->name('reports.sales.excel');
    });

    // Solo el administrador: Configuraciones
    Route::middleware('role:Administrador')->group(function () {
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('roles', RoleController::class)->except('show');
        Route::resource('users', UserController::class)->except('show');
    });
});
