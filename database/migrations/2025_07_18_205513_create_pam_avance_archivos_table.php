<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * Este método se encarga de crear la tabla 'pam_avance_archivos' en la base de datos.
     */
    public function up(): void
    {
        Schema::create('pam_avance_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pam_avance_id')
                  ->constrained('pam_avances')
                  ->onDelete('cascade');

            $table->string('nombre_original');
            $table->string('ruta_archivo');
            $table->string('tipo_mime')->nullable();
            $table->unsignedBigInteger('tamano')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     *
     */
    public function down(): void
    {
        Schema::dropIfExists('pam_avance_archivos');
    }
};
