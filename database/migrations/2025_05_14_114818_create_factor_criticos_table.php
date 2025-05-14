<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new  class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factor_criticos', function (Blueprint $table) {
            $table->id();
            // Claves foráneas para relacionar con autoevaluacion y grupo_calificacions
            $table->foreignId('autoevaluacion_id')->constrained()->onDelete('cascade');
            $table->foreignId('grupo_calificacion_id')->constrained()->onDelete('cascade');

            $table->text('descripcion');
            $table->integer('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factor_criticos');
    }
};
