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
        Schema::create('pmi_indicadors', function (Blueprint $table) {
            $table->id();
            $table->string('unidad_total')
                ->comment("ES LA CANTIDAD TOTAL: TOTAL DE PROFESORES");
            $table->string('unidad_parcial')
                ->comment("ES LA UNIDAD PARCIAL: TOTAL DE PROFESORES EVALUADOS");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmi_indicadors');
    }
};
