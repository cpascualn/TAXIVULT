<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return response()->json(['mensaje' => '¡Hola desde la API!']);
});


Route::get('/home', function () {
    return view('welcome');
});

// Ruta con un controlador
Route::get('/user/{id}', [UsuarioController::class, 'show']);
