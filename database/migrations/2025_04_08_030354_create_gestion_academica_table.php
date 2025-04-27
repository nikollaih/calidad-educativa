<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla principal: gestion_academica
        Schema::create('gestion_academica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institucions')->onDelete('cascade');
        });

        // Tabla: ga_disenos_pedagogicos
        Schema::create('ga_disenos_pedagogicos', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_academica_id')->primary();
            $table->text('plan_estudios');
            $table->text('enfoque_metodologico');
            $table->text('estrategia_pedagogica');
            $table->text('analisis_jornada_escolar');
            $table->text('sistema_evaluacion');
            $table->unsignedBigInteger('anexo_plan_estudios')->nullable();
            $table->unsignedBigInteger('anexo_enfoque_pedagogico')->nullable();
            $table->unsignedBigInteger('anexo_analisis_jornada')->nullable();
            $table->unsignedBigInteger('anexo_sistema_evaluacion')->nullable();
            $table->timestamps();

            $table->foreign('gestion_academica_id')->references('id')->on('gestion_academica')->onDelete('cascade');
            $table->foreign('anexo_plan_estudios')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_enfoque_pedagogico')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_analisis_jornada')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_sistema_evaluacion')->references('id')->on('adjuntos')->nullOnDelete();
        });

        // Tabla: ga_practicas_pedagogicas
        Schema::create('ga_practicas_pedagogicas', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_academica_id')->primary();
            $table->text('estrategias_tareas');
            $table->timestamps();

            $table->foreign('gestion_academica_id')->references('id')->on('gestion_academica')->onDelete('cascade');
        });

        // Tabla: ga_gestion_aulas
        Schema::create('ga_gestion_aulas', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_academica_id')->primary();
            $table->text('ambientes_aprendizaje');
            $table->text('motivacion_aprendizaje');
            $table->text('plan_aula');
            $table->text('evaluacion_aula');
            $table->unsignedBigInteger('anexos_planes_aula')->nullable();
            $table->unsignedBigInteger('anexos_temas_ensenanza')->nullable();
            $table->timestamps();

            $table->foreign('gestion_academica_id')->references('id')->on('gestion_academica')->onDelete('cascade');
            $table->foreign('anexos_planes_aula')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexos_temas_ensenanza')->references('id')->on('adjuntos')->nullOnDelete();
        });

        // Tabla: ga_seguimientos_academicos
        Schema::create('ga_seguimientos_academicos', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_academica_id')->primary();
            $table->unsignedBigInteger('anexo_informe_estadistico')->nullable();
            $table->unsignedBigInteger('anexo_analisis_pruebas_externas')->nullable();
            $table->unsignedBigInteger('anexos_planes_mejoramiento')->nullable();
            $table->text('seguimiento_desempenos');
            $table->text('uso_evaluaciones_externas');
            $table->text('apoyo_pedagogico');
            $table->timestamps();
            $table->foreign('gestion_academica_id')->references('id')->on('gestion_academica')->onDelete('cascade');
            $table->foreign('anexo_informe_estadistico')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_analisis_pruebas_externas', 'ga_seguimientos_academicos_anexo_analisis_f')->references('id')->on('adjuntos')->onDelete('set null');
            $table->foreign('anexos_planes_mejoramiento')->references('id')->on('adjuntos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ga_seguimientos_academicos');
        Schema::dropIfExists('ga_gestion_aulas');
        Schema::dropIfExists('ga_practicas_pedagogicas');
        Schema::dropIfExists('ga_disenos_pedagogicos');
        Schema::dropIfExists('gestion_academica');
    }
};
