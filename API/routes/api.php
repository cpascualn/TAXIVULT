<?php

use Illuminate\http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\UsuarioController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return response()->json([
        'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
    ]);
});




// Otras rutas API públicas
Route::get('/public', function () {
    return response()->json(['message' => 'Esta es una ruta pública']);
});
