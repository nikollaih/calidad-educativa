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
        Schema::create('factor_critico_calificacions', function (Blueprint $table) {
            $table->id();
            $table->text("descripcion")->comment("es la descripcion del factor critico");
            $table->string("indice_calificacion")->comment("es el nombre del factor critico");
            $table->foreign('indice_calificacion')->references('indice')->on('calificacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factor_critico_calificacions');
    }
};
