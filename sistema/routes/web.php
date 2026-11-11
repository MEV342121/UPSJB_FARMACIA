<?php

use App\Http\Controllers\CategoryController;
use App\Models\Medicamento;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('template.administrador');
});

Route::get('/medicamentos', function () {
    return Medicamento::with('categoria')->get();
});

Route::get('/medicamentos/{id}', function ($id) {
    return Medicamento::with('categoria')->findOrFail($id);
});

Route::resource('categories', CategoryController::class)->except('show');