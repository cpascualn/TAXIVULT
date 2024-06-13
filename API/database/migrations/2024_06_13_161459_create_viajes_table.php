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
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_conductor')->constrained('conductors');
            $table->foreignId('id_pasajero')->constrained('pasajeros');
            $table->decimal('lati_ini', 9, 6);
            $table->decimal('longi_ini', 9, 6);
            $table->decimal('lati_fin', 9, 6);
            $table->decimal('longi_fin', 9, 6);
            $table->timestamp('fecha_ini');
            $table->timestamp('fecha_fin')->nullable();
            $table->enum('metodo_pago', ['efectivo', 'tarjeta']);
            $table->boolean('cancelado')->default(false);
            $table->timestamp('fecha_cancelacion')->nullable();
            $table->decimal('distancia', 6, 2);
            $table->integer('duracion_min');
            $table->decimal('precio_total', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
