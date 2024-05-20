<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email', 30);
            $table->string('telefono', 15);
            $table->string('nombre', 30);
            $table->string('apellidos', 50);
            $table->string('contrasena', 30);
            $table->unsignedBigInteger('ciudad');
            $table->unsignedBigInteger('fecha_creacion');
            $table->unsignedBigInteger('rol');
            $table->timestamps();

            // // Definir restricciones de clave foránea
            // $table->foreign('ciudad')->references('id')->on('ciudades');
            // $table->foreign('rol')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
