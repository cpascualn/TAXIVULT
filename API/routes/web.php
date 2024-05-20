<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['mensaje' => '¡Hola desde la API!']);
});
