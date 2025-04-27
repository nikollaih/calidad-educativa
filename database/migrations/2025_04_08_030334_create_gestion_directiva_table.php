<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla principal: gestion_directiva
        Schema::create('gestion_directiva', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institucions')->onDelete('cascade');
        });

        // Tabla: gd_direccionamiento_estrategico
        Schema::create('gd_direccionamiento_estrategico', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_directiva_id')->primary();
            $table->text('mision');
            $table->text('vision');
            $table->text('principios_institucionales');
            $table->text('metas_institucionales');
            $table->text('politica_inclusion');
            $table->unsignedBigInteger('anexo_politica_inclusion')->nullable();
            $table->timestamps();

            $table->foreign('gestion_directiva_id')->references('id')->on('gestion_directiva')->onDelete('cascade');
            $table->foreign('anexo_politica_inclusion')->references('id')->on('adjuntos')->nullOnDelete();
        });

        // Tabla: gd_gestion_estrategica
        Schema::create('gd_gestion_estrategica', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_directiva_id')->primary();
            $table->text('liderazgo');
            $table->text('articulacion');
            $table->text('seguimiento');
            $table->timestamps();

            $table->foreign('gestion_directiva_id')->references('id')->on('gestion_directiva')->onDelete('cascade');
        });

        // Tabla: gd_gobierno_escolar
        Schema::create('gd_gobierno_escolar', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_directiva_id')->primary();
            $table->text('gobierno_escolar');
            $table->unsignedBigInteger('anexo_gobierno_escolar')->nullable();
            $table->timestamps();

            $table->foreign('gestion_directiva_id')->references('id')->on('gestion_directiva')->onDelete('cascade');
            $table->foreign('anexo_gobierno_escolar')->references('id')->on('adjuntos')->nullOnDelete();
        });

        // Tabla: gd_cultura_institucional
        Schema::create('gd_cultura_institucional', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_directiva_id')->primary();
            $table->text('politica_comunicacion');
            $table->unsignedBigInteger('anexo_cultura_institucional')->nullable();
            $table->text('politica_bienestar');
            $table->unsignedBigInteger('anexo_politica_bienestar')->nullable();
            $table->text('inventario_buenas_practicas');
            $table->timestamps();

            $table->foreign('gestion_directiva_id')->references('id')->on('gestion_directiva')->onDelete('cascade');
            $table->foreign('anexo_cultura_institucional')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_politica_bienestar')->references('id')->on('adjuntos')->nullOnDelete();
        });

        // Tabla: gd_clima_escolar
        Schema::create('gd_clima_escolar', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_directiva_id')->primary();
            $table->text('sentido_pertenencia');
            $table->text('induccion_institucional');
            $table->unsignedBigInteger('anexo_programa_institucional_induccion')->nullable();
            $table->unsignedBigInteger('manual_convivencia')->nullable();
            $table->text('actividades_extracurriculares');
            $table->text('manejo_conflictos');
            $table->timestamps();

            $table->foreign('gestion_directiva_id')->references('id')->on('gestion_directiva')->onDelete('cascade');
            $table->foreign('anexo_programa_institucional_induccion')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('manual_convivencia')->references('id')->on('adjuntos')->nullOnDelete();
        });

        // Tabla: gd_relaciones_entorno
        Schema::create('gd_relaciones_entorno', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_directiva_id')->primary();
            $table->text('relacion_familias');
            $table->text('seguimiento_egresados');
            $table->text('alianzas_instituciones');
            $table->unsignedBigInteger('anexo_alianzas_instituciones')->nullable();
            $table->text('alianzas_sector_productivo');
            $table->unsignedBigInteger('anexo_alianzas_sector_productivo')->nullable();
            $table->timestamps();

            $table->foreign('gestion_directiva_id')->references('id')->on('gestion_directiva')->onDelete('cascade');
            $table->foreign('anexo_alianzas_instituciones')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_alianzas_sector_productivo')->references('id')->on('adjuntos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Eliminar tablas hijas en orden inverso
        Schema::dropIfExists('gd_relaciones_entorno');
        Schema::dropIfExists('gd_clima_escolar');
        Schema::dropIfExists('gd_cultura_institucional');
        Schema::dropIfExists('gd_gobierno_escolar');
        Schema::dropIfExists('gd_gestion_estrategica');
        Schema::dropIfExists('gd_direccionamiento_estrategico');

        // Finalmente la tabla principal
        Schema::dropIfExists('gestion_directiva');
    }
};
