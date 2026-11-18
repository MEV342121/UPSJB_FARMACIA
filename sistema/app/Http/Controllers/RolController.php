<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view("settings.roles.index", compact('roles'));
    }

    public function create()
    {
        return view("settings.roles.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:roles,nombre',
            'description' => 'nullable|max:255'
        ]);

        Role::create([
            'nombre' => $validated['name'],
            'descripcion' => $validated['description'] ?? null
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Rol registrado correctamente.');
    }

    public function show(Role $role)
    {
        return view('settings.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('settings.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:50',
                Rule::unique('roles', 'nombre')->ignore($role->id),
            ],
            'description' => 'nullable|max:255'
        ]);

        $role->update([
            'nombre' => $validated['name'],
            'descripcion' => $validated['description'] ?? null
        ]);

        return to_route('roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return to_route('roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}
