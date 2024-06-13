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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->time('hora_ini1');
            $table->time('hora_fin1');
            $table->time('hora_ini2')->nullable();
            $table->time('hora_fin2')->nullable();
            $table->decimal('tarifa_dia', 4, 2);
            $table->decimal('tarifa_minuto', 4, 2);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
