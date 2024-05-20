<?php

use Illuminate\http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/hola', function () {
    return response()->json(['mensaje' => '¡Hola desde la API!']);
});


Route::get('/', function () {
    return response()->json(['mensaje' => '¡Hola desde la API!']);
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Otras rutas API públicas
Route::get('/public', function () {
    return response()->json(['message' => 'Esta es una ruta pública']);
});
