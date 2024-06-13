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
        Schema::create('bloqueado_conductors', function (Blueprint $table) {
            $table->foreignId('id_conductor')->constrained('conductors');
            $table->foreignId('id_pasajero')->constrained('pasajeros');
            $table->primary(['id_conductor', 'id_pasajero']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloqueado_conductors');
    }
};
