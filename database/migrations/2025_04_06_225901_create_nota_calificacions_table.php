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
        Schema::create('nota_calificacions', function (Blueprint $table) {
            $table->id();
            $table->integer("valor")->comment("es el valor de la nota");
            $table->text("descripcion")->comment("es la descripcion de la nota");
            $table->string("indice_calificacion")->comment("es el nombre de la nota");
            $table->foreign('indice_calificacion')->references('indice')->on('calificacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_calificacions');
    }
};
