<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index()
    {
        $medicines = Medicamento::with('categoria')->latest()->get();

        return view('managament.medicines.index', compact('medicines'));
    }

    public function create()
    {
        $categories = Categoria::orderBy('nombre')->get();

        return view('managament.medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => ['required', 'exists:categorias,id'],
            'nombre' => ['required', 'string', 'max:150'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        Medicamento::create($validated);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicamento registrado correctamente.');
    }

    public function edit(Medicamento $medicine)
    {
        $categories = Categoria::orderBy('nombre')->get();

        return view('managament.medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicamento $medicine)
    {
        $validated = $request->validate([
            'categoria_id' => ['required', 'exists:categorias,id'],
            'nombre' => ['required', 'string', 'max:150'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $medicine->update($validated);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicamento actualizado correctamente.');
    }

    public function destroy(Medicamento $medicine)
    {
        $medicine->delete();

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicamento eliminado correctamente.');
    }
}