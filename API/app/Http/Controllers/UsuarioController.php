<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'nullable|string|max:15',
            'nombre' => 'required|string|max:30',
            'apellidos' => 'required|string|max:30',
            'contrasena' => 'required|string|min:8',
            'ciudad' => 'nullable|exists:ciudads,id',
            'fecha_creacion' => 'required|date',
            'rol' => 'nullable|exists:rols,id',
        ]);

        $usuario = new Usuario([
            'email' => $request->email,
            'telefono' => $request->telefono,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'contrasena' => Hash::make($request->contrasena),
            'ciudad' => $request->ciudad,
            'fecha_creacion' => $request->fecha_creacion,
            'rol' => $request->rol,
        ]);

        $usuario->save();

        return response()->json($usuario, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'telefono' => 'nullable|string|max:15',
            'nombre' => 'required|string|max:30',
            'apellidos' => 'required|string|max:30',
            'contrasena' => 'nullable|string|min:8',
            'ciudad' => 'nullable|exists:ciudads,id',
            'fecha_creacion' => 'required|date',
            'rol' => 'nullable|exists:rols,id',
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;

        if ($request->filled('contrasena')) {
            $usuario->contrasena = Hash::make($request->contrasena);
        }

        $usuario->ciudad = $request->ciudad;
        $usuario->fecha_creacion = $request->fecha_creacion;
        $usuario->rol = $request->rol;

        $usuario->save();

        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(null, 204);
    }
}
