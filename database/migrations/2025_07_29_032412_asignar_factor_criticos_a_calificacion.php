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
        Schema::table('factor_criticos', function (Blueprint $table) {
            // 1. Eliminar la restricción de clave foránea existente
            $table->dropForeign(['grupo_calificacion_id']);

            // 2. Eliminar la columna existente
            $table->dropColumn('grupo_calificacion_id');

            // 3. Agregar la nueva columna que apuntará al índice de calificacions
            $table->string('calificacion_indice')->after('autoevaluacion_id');

            // 4. Crear la nueva relación basada en el campo indice
            $table->foreign('calificacion_indice')
                ->references('indice')
                ->on('calificacions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factor_criticos', function (Blueprint $table) {
            // 1. Eliminar la nueva relación
            $table->dropForeign(['calificacion_indice']);

            // 2. Eliminar la nueva columna
            $table->dropColumn('calificacion_indice');

            // 3. Volver a crear la columna original
            $table->foreignId('grupo_calificacion_id')->constrained()->onDelete('cascade');
        });
    }
};
