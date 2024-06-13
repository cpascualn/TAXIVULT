<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('conductors', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 15)->unique();
            $table->string('licencia_taxista', 15)->nullable();
            $table->string('titular_tarjeta', 30);
            $table->string('iban_tarjeta', 30);
            $table->decimal('tiempo_espera', 6, 4);
            $table->decimal('lati_espera', 9, 6);
            $table->enum('estado', ['libre', 'ocupado', 'fuera de servicio']);
            $table->string('coche', 12)->nullable();
            $table->foreignId('horario')->constrained('horarios');
            $table->foreignId('id')->constrained('usuarios');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductors');
    }
};
