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
        Schema::create('ubicacion_favs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->decimal('longitud', 9, 6);
            $table->decimal('latitud', 9, 6);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicacion_favs');
    }
};
