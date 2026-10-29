<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios registrados.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        // Forzamos el username a mayúsculas antes de validar
        $request->merge([
            'username' => strtoupper($request->username),
        ]);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,agent',
            'grupo'    => 'nullable|string|max:255',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username, // Ya viajará en mayúsculas
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'grupo'    => $request->grupo,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        // Forzamos el username a mayúsculas también al actualizar
        $request->merge([
            'username' => strtoupper($request->username),
        ]);

        $usuario = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $usuario->id,
            'email'    => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'role'     => 'required|in:admin,agent',
            'grupo'    => 'nullable|string|max:255',
        ]);

        $usuario->name = $request->name;
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->role = $request->role;
        $usuario->grupo = $request->grupo;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }
}
