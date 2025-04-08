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
        Schema::create('calificacions', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->comment("es el nombre del grupo de calificaciones");
            $table->string("indice")->unique()->comment("es el indice del grupo de calificaciones");
            $table->string('grupo_indice')->comment("es el indice del  grupo de calificaciones al que pertenece");
            $table->foreign('grupo_indice')->references('indice')->on('grupo_calificacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacions');
    }
};
