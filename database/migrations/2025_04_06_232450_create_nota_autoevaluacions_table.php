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
        Schema::create('nota_autoevaluacions', function (Blueprint $table) {
            $table->unsignedBigInteger('autoevaluacion_id');
            $table->unsignedBigInteger('nota_calificacion_id');
            $table->text('evidencia')->nullable();

            // Clave primaria compuesta
            $table->primary(['autoevaluacion_id', 'nota_calificacion_id']);
            $table->timestamps();

            // Claves foráneas
            $table->foreign('autoevaluacion_id')
                ->references('id')
                ->on('autoevaluacions')
                ->onDelete('cascade');

            $table->foreign('nota_calificacion_id')
                ->references('id')
                ->on('nota_calificacions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_autoevaluacions');
    }
};
