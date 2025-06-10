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
        Schema::table('institucions', function (Blueprint $table) {
            $table->unsignedBigInteger('municipio_id')->nullable();

            // Crear la foreign key constraint
            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipios')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institucions', function (Blueprint $table) {
            // Primero eliminar la foreign key constraint
            $table->dropForeign(['municipio_id']);

            // Luego eliminar la columna
            $table->dropColumn('municipio_id');
        });
    }
};
