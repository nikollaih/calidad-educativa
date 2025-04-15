<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('gestion_directiva', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            
            // Direccionamiento Estratégico
            $table->text('mision');
            $table->text('vision');
            $table->text('principios_institucionales');
            $table->text('metas_institucionales');
            $table->text('politica_inclusion');
            $table->string('anexo_politica_inclusion')->nullable();
            
            // Gestión Estratégica
            $table->text('liderazgo');
            $table->text('articulacion');
            $table->text('seguimiento');
            
            // Gobierno Escolar
            $table->text('gobierno_escolar');
            $table->string('anexo_gobierno_escolar')->nullable();
            
            // Cultura Institucional
            $table->text('politica_comunicacion');
            $table->string('anexo_cultura_institucional')->nullable();
            $table->text('politica_bienestar');
            $table->string('anexo_politica_bienestar')->nullable();
            // $table->text('apoyo_investigacion');
            $table->text('inventario_buenas_practicas');
            
            // Clima Escolar
            $table->text('sentido_pertenencia');
            $table->text('induccion_institucional');
            $table->string('anexo_programa_institucional_induccion')->nullable();
            $table->string('manual_convivencia')->nullable();
            $table->text('actividades_extracurriculares');
            $table->text('manejo_conflictos');
            
            // Relaciones con el Entorno
            $table->text('relacion_familias');
            $table->text('seguimiento_egresados');
            $table->text('alianzas_instituciones');
            $table->string('anexo_alianzas_instituciones')->nullable();
            $table->text('alianzas_sector_productivo');
            $table->string('anexo_alianzas_sector_productivo')->nullable();

            $table->foreign('institution_id')->references('id')->on('institucions');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('gestion_directiva', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
        });
        Schema::dropIfExists('gestion_directiva');
    }
};