<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla: gd_direccionamiento_estrategico
        Schema::table('gd_direccionamiento_estrategico', function (Blueprint $table) {
            $table->text('mision')->nullable()->change();
            $table->text('vision')->nullable()->change();
            $table->text('principios_institucionales')->nullable()->change();
            $table->text('metas_institucionales')->nullable()->change();
            $table->text('politica_inclusion')->nullable()->change();
        });

        // Tabla: gd_gestion_estrategica
        Schema::table('gd_gestion_estrategica', function (Blueprint $table) {
            $table->text('liderazgo')->nullable()->change();
            $table->text('articulacion')->nullable()->change();
            $table->text('seguimiento')->nullable()->change();
        });

        // Tabla: gd_gobierno_escolar
        Schema::table('gd_gobierno_escolar', function (Blueprint $table) {
            $table->text('gobierno_escolar')->nullable()->change();
        });

        // Tabla: gd_cultura_institucional
        Schema::table('gd_cultura_institucional', function (Blueprint $table) {
            $table->text('politica_comunicacion')->nullable()->change();
            $table->text('politica_bienestar')->nullable()->change();
            $table->text('inventario_buenas_practicas')->nullable()->change();
        });

        // Tabla: gd_clima_escolar
        Schema::table('gd_clima_escolar', function (Blueprint $table) {
            $table->text('sentido_pertenencia')->nullable()->change();
            $table->text('induccion_institucional')->nullable()->change();
            $table->text('actividades_extracurriculares')->nullable()->change();
            $table->text('manejo_conflictos')->nullable()->change();
        });

        // Tabla: gd_relaciones_entorno
        Schema::table('gd_relaciones_entorno', function (Blueprint $table) {
            $table->text('relacion_familias')->nullable()->change();
            $table->text('seguimiento_egresados')->nullable()->change();
            $table->text('alianzas_instituciones')->nullable()->change();
            $table->text('alianzas_sector_productivo')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Revertir los cambios (hacer los campos no nulos nuevamente)
        
        // Tabla: gd_direccionamiento_estrategico
        Schema::table('gd_direccionamiento_estrategico', function (Blueprint $table) {
            $table->text('mision')->nullable(false)->change();
            $table->text('vision')->nullable(false)->change();
            $table->text('principios_institucionales')->nullable(false)->change();
            $table->text('metas_institucionales')->nullable(false)->change();
            $table->text('politica_inclusion')->nullable(false)->change();
        });

        // Tabla: gd_gestion_estrategica
        Schema::table('gd_gestion_estrategica', function (Blueprint $table) {
            $table->text('liderazgo')->nullable(false)->change();
            $table->text('articulacion')->nullable(false)->change();
            $table->text('seguimiento')->nullable(false)->change();
        });

        // Tabla: gd_gobierno_escolar
        Schema::table('gd_gobierno_escolar', function (Blueprint $table) {
            $table->text('gobierno_escolar')->nullable(false)->change();
        });

        // Tabla: gd_cultura_institucional
        Schema::table('gd_cultura_institucional', function (Blueprint $table) {
            $table->text('politica_comunicacion')->nullable(false)->change();
            $table->text('politica_bienestar')->nullable(false)->change();
            $table->text('inventario_buenas_practicas')->nullable(false)->change();
        });

        // Tabla: gd_clima_escolar
        Schema::table('gd_clima_escolar', function (Blueprint $table) {
            $table->text('sentido_pertenencia')->nullable(false)->change();
            $table->text('induccion_institucional')->nullable(false)->change();
            $table->text('actividades_extracurriculares')->nullable(false)->change();
            $table->text('manejo_conflictos')->nullable(false)->change();
        });

        // Tabla: gd_relaciones_entorno
        Schema::table('gd_relaciones_entorno', function (Blueprint $table) {
            $table->text('relacion_familias')->nullable(false)->change();
            $table->text('seguimiento_egresados')->nullable(false)->change();
            $table->text('alianzas_instituciones')->nullable(false)->change();
            $table->text('alianzas_sector_productivo')->nullable(false)->change();
        });
    }
};