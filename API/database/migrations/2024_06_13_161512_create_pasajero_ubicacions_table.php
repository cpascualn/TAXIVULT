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
        Schema::create('pasajero_ubicacions', function (Blueprint $table) {
            $table->foreignId('id_ubicacion')->constrained('ubicacion_favs');
            $table->foreignId('id_pasajero')->constrained('pasajeros');
            $table->primary(['id_ubicacion', 'id_pasajero']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajero_ubicacions');
    }
};
