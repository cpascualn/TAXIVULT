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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('email', 30)->unique();
            $table->string('telefono', 15)->nullable();
            $table->string('nombre', 30);
            $table->string('apellidos', 50);
            $table->string('contrasena', 30);
            $table->foreignId('ciudad')->constrained('ciudads');
            $table->date('fecha_creacion');
            $table->foreignId('rol')->constrained('rols');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
