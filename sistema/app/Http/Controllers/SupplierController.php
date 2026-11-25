<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    // Lista los proveedores más recientes primero.
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('management.suppliers.index', compact('suppliers'));
    }

    // Muestra el formulario para registrar un proveedor.
    public function create()
    {
        return view('management.suppliers.create');
    }

    // Valida y guarda un nuevo proveedor.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'ruc' => ['required', 'digits:11', Rule::unique('suppliers', 'ruc')],
            'phone' => 'nullable|digits:9',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:150',
        ]);

        Supplier::create($validated);

        return to_route('suppliers.index')->with('ok', 'Proveedor registrado');
    }

    // Muestra el formulario con los datos del proveedor seleccionado.
    public function edit(Supplier $supplier)
    {
        return view('management.suppliers.edit', compact('supplier'));
    }

    // Valida y actualiza el proveedor, permitiendo conservar su propio RUC.
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'ruc' => ['required', 'digits:11', Rule::unique('suppliers', 'ruc')->ignore($supplier->id)],
            'phone' => 'nullable|digits:9',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:150',
        ]);

        $supplier->update($validated);

        return to_route('suppliers.index')->with('ok', 'Proveedor actualizado');
    }

    // Elimina el proveedor seleccionado.
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return to_route('suppliers.index')->with('ok', 'Proveedor eliminado');
    }
}
