<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // GET /login: muestra el formulario
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // POST /login: comprueba el correo y la contraseña
    public function login(Request $request)
    {
        // 1. Los dos campos son obligatorios
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Auth::attempt busca el correo y compara la contraseña con el hash guardado.
        //    El segundo parámetro es la casilla «Recordarme».
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // 3. Nuevo identificador de sesión (evita el robo de sesión)
            $request->session()->regenerate();

            // 4. Va a la página que quería abrir o, si no, al dashboard
            return redirect()->intended(route('dashboard.index'));
        }

        // 5. Datos incorrectos: vuelve al login con un mensaje y el correo escrito
        return back()
            ->withErrors(['email' => 'El correo o la contraseña no son correctos.'])
            ->onlyInput('email');
    }

    // POST /logout: cierra la sesión
    public function logout(Request $request)
    {
        Auth::logout();                          // olvida al usuario
        $request->session()->invalidate();       // borra los datos de la sesión
        $request->session()->regenerateToken();  // nuevo token CSRF

        return to_route('login')->with('ok', 'Cerraste sesión correctamente.');
    }
}
