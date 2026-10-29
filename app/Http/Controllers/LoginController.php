<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Muestra la vista del Login
    public function showLoginForm()
    {
        return view('login.index'); // Ajusta la ruta si tu archivo blade tiene otro nombre/ubicación
    }

    public function login(Request $request)
    {
        // 1. Validar inputs
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'El usuario es obligatorio.',
            'password.required' => 'La clave es obligatoria.',
        ]);

        $usernameMayuscula = strtoupper($credentials['username']);

        // 2. Intentar autenticación usando la variable en mayúsculas
        if (Auth::attempt(['username' => $usernameMayuscula, 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // Redirección exitosa a la ruta main.index
            return redirect()->intended(route('main.index'));
        }

        // 3. Fallo de autenticación
        return back()->withErrors([
            'username' => 'Las credenciales ingresadas no son válidas.',
        ])->onlyInput('username');
    }

    // Cerrar Sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
