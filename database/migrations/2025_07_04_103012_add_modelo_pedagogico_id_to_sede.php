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
        Schema::table('sedes', function (Blueprint $table) {
            $table->unsignedBigInteger('modelo_pedagogico_id')->nullable();

            // Crear la foreign key constraint
            $table->foreign('modelo_pedagogico_id')
                ->references('id')
                ->on('modelo_pedagogicos')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institucion', function (Blueprint $table) {
            //
        });
    }
};
