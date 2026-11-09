<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Medicamento;

Route::get('/medicamentos', function () {
    return Medicamento::with('categoria')->get();
});

Route::get('/medicamentos/{id}', function ($id) {
    return Medicamento::with('categoria')->findOrFail($id);
});
