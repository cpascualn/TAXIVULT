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
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id();
            $table->string('n_tarjeta', 30)->unique();
            $table->string('titular_tarjeta', 15);
            $table->string('caducidad_tarjeta', 30);
            $table->string('cvv_tarjeta', 30);
            $table->foreignId('id')->constrained('usuarios');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajeros');
    }
};
