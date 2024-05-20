<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula', 12)->unique();
            $table->integer('capacidad');
            $table->string('fabricante', 30);
            $table->string('modelo', 30);
            $table->enum('tipo', ['comun', 'van']);
            $table->binary('imagen')->nullable();
            $table->integer('conductor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
