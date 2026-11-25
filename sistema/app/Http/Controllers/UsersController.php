<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('rol')->latest()->get();

        return view('settings.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Rol::orderBy('nombre')->get();

        return view('settings.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'rol_id' => ['required', 'exists:roles,id'],
            'dni' => ['nullable', 'string', 'max:20', 'unique:users,dni'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'colegiatura' => ['nullable', 'string', 'max:50'],
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('ok', 'Usuario registrado correctamente.');
    }

    public function edit(User $user)
    {
        $roles = Rol::orderBy('nombre')->get();

        return view('settings.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'rol_id' => ['required', 'exists:roles,id'],
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('users', 'dni')->ignore($user->id)],
            'telefono' => ['nullable', 'string', 'max:20'],
            'colegiatura' => ['nullable', 'string', 'max:50'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('ok', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('ok', 'Usuario eliminado correctamente.');
    }
}