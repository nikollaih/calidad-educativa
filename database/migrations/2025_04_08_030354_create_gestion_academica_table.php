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
        Schema::create('gestion_academica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            $table->text('plan_estudios');
            $table->text('enfoque_metodologico');
            $table->text('estrategia_pedagogica');
            $table->text('analisis_jornada_escolar');
            $table->text('sistema_evaluacion');
            $table->text('estrategias_tareas');
            $table->text('ambientes_aprendizaje');
            $table->text('motivacion_aprendizaje');
            $table->text('plan_aula');
            $table->text('evaluacion_aula');
            $table->text('seguimiento_desempenos');
            $table->text('uso_evaluaciones_externas');
            $table->text('apoyo_pedagogico');
            $table->string('anexo_plan_estudios')->nullable();
            $table->string('anexo_enfoque_pedagogico')->nullable();
            $table->string('anexo_analisis_jornada')->nullable();
            $table->string('anexo_sistema_evaluacion')->nullable();
            $table->string('anexos_planes_aula')->nullable();
            $table->string('anexos_temas_ensenanza')->nullable();
            $table->string('anexo_informe_estadistico')->nullable();
            $table->string('anexo_analisis_pruebas_externas')->nullable();
            $table->string('anexos_planes_mejoramiento')->nullable();
            
            $table->foreign('institution_id')->references('id')->on('institucions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestion_academica', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
        });
        Schema::dropIfExists('gestion_academica');
    }
};
