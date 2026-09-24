<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla: ga_disenos_pedagogicos
        Schema::table('ga_disenos_pedagogicos', function (Blueprint $table) {
            $table->text('plan_estudios')->nullable()->change();
            $table->text('enfoque_metodologico')->nullable()->change();
            $table->text('estrategia_pedagogica')->nullable()->change();
            $table->text('analisis_jornada_escolar')->nullable()->change();
            $table->text('sistema_evaluacion')->nullable()->change();
        });

        // Tabla: ga_practicas_pedagogicas
        Schema::table('ga_practicas_pedagogicas', function (Blueprint $table) {
            $table->text('estrategias_tareas')->nullable()->change();
        });

        // Tabla: ga_gestion_aulas
        Schema::table('ga_gestion_aulas', function (Blueprint $table) {
            $table->text('ambientes_aprendizaje')->nullable()->change();
            $table->text('motivacion_aprendizaje')->nullable()->change();
            $table->text('plan_aula')->nullable()->change();
            $table->text('evaluacion_aula')->nullable()->change();
        });

        // Tabla: ga_seguimientos_academicos
        Schema::table('ga_seguimientos_academicos', function (Blueprint $table) {
            $table->text('seguimiento_desempenos')->nullable()->change();
            $table->text('uso_evaluaciones_externas')->nullable()->change();
            $table->text('apoyo_pedagogico')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Revertir los cambios (hacer los campos no nulos nuevamente)
        
        // Tabla: ga_disenos_pedagogicos
        Schema::table('ga_disenos_pedagogicos', function (Blueprint $table) {
            $table->text('plan_estudios')->nullable(false)->change();
            $table->text('enfoque_metodologico')->nullable(false)->change();
            $table->text('estrategia_pedagogica')->nullable(false)->change();
            $table->text('analisis_jornada_escolar')->nullable(false)->change();
            $table->text('sistema_evaluacion')->nullable(false)->change();
        });

        // Tabla: ga_practicas_pedagogicas
        Schema::table('ga_practicas_pedagogicas', function (Blueprint $table) {
            $table->text('estrategias_tareas')->nullable(false)->change();
        });

        // Tabla: ga_gestion_aulas
        Schema::table('ga_gestion_aulas', function (Blueprint $table) {
            $table->text('ambientes_aprendizaje')->nullable(false)->change();
            $table->text('motivacion_aprendizaje')->nullable(false)->change();
            $table->text('plan_aula')->nullable(false)->change();
            $table->text('evaluacion_aula')->nullable(false)->change();
        });

        // Tabla: ga_seguimientos_academicos
        Schema::table('ga_seguimientos_academicos', function (Blueprint $table) {
            $table->text('seguimiento_desempenos')->nullable(false)->change();
            $table->text('uso_evaluaciones_externas')->nullable(false)->change();
            $table->text('apoyo_pedagogico')->nullable(false)->change();
        });
    }
};