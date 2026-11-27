<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    // Listado de clientes
    public function index()
    {
        $customers = Customer::latest()->get();

        return view('management.customers.index', compact('customers'));
    }

    // Formulario para crear
    public function create()
    {
        return view('management.customers.create');
    }

    // Guardar nuevo cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'dni' => 'required|digits:8|unique:customers',
            'phone' => 'nullable|digits:9',
            'age' => 'nullable|integer|min:0|max:120',
        ]);

        Customer::create($validated);

        return to_route('customers.index')->with('ok', 'Cliente registrado');
    }

    // Formulario para editar
    public function edit(Customer $customer)
    {
        return view('management.customers.edit', compact('customer'));
    }

    // Actualizar cliente
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            // ignore(): el DNI no se repite, sin contar el cliente que se está editando
            'dni' => ['required', 'digits:8', Rule::unique('customers')->ignore($customer->id)],
            'phone' => 'nullable|digits:9',
            'age' => 'nullable|integer|min:0|max:120',
        ]);

        $customer->update($validated);

        return to_route('customers.index')->with('ok', 'Cliente actualizado');
    }

    // Eliminar cliente (solo si no tiene ventas)
    public function destroy(Customer $customer)
    {
        if ($customer->sales()->exists()) {
            return to_route('customers.index')->with('error', 'No se puede eliminar el cliente porque tiene ventas registradas');
        }

        $customer->delete();

        return to_route('customers.index')->with('ok', 'Cliente eliminado');
    }
}
