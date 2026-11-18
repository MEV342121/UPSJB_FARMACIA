<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolController;



Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index'); 

Route::resource('categories', CategoryController::class)->except('show');

Route::resource('roles', RolController::class)->except('show');

Route::resource('customer', CustomerController::class)->except('show');