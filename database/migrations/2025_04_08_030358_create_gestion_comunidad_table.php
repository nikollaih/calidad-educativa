<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear tabla gestion_comunidad
        Schema::create('gestion_comunidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institucions')->onDelete('cascade');
            $table->timestamps();
        });

        // Crear tabla gc_atencion_grupos_poblacionales
        Schema::create('gc_atencion_grupos_poblacionales', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_comunidad_id')->primary();
            $table->text('atencion_grupos_vulnerabilidad')->nullable();
            $table->text('necesidades_expectativas_estudiantes')->nullable();
            $table->text('proyectos_vida')->nullable();
            $table->text('escuela_padres')->nullable();
            $table->text('oferta_servicios_comunidad')->nullable();
            $table->unsignedBigInteger('anexo_proyecto_escuela_padres_id')->nullable();
            $table->foreign('gestion_comunidad_id')->references('id')->on('gestion_comunidad')->onDelete('cascade');
            $table->foreign('anexo_proyecto_escuela_padres_id', 'anexo_p_es_p_adjunto_fk')->references('id')->on('adjuntos')->nullOnDelete();
            $table->timestamps();
        });

        // Crear tabla gc_programa_servicio_social
        Schema::create('gc_programa_servicio_social', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_comunidad_id')->primary();
            $table->text('programa_servicio_social')->nullable();
            $table->unsignedBigInteger('anexo_programa_servicio_social_id')->nullable();
            $table->foreign('gestion_comunidad_id')->references('id')->on('gestion_comunidad')->onDelete('cascade');
            $table->foreign('anexo_programa_servicio_social_id', 'programa_servicio_social_fk')->references('id')->on('adjuntos')->nullOnDelete();
            $table->timestamps();
        });

        // Crear tabla gc_prevencion_riesgos
        Schema::create('gc_prevencion_riesgos', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_comunidad_id')->primary();
            $table->text('prevencion_riesgos_fisicos')->nullable();
            $table->unsignedBigInteger('anexo_prevencion_riesgos_fisicos_id')->nullable();
            $table->text('prevencion_riesgos_psicosociales')->nullable();
            $table->foreign('gestion_comunidad_id')->references('id')->on('gestion_comunidad')->onDelete('cascade');
            $table->foreign('anexo_prevencion_riesgos_fisicos_id', 'prevencion_riesgos_fisico_fk')->references('id')->on('adjuntos')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gc_prevencion_riesgos');
        Schema::dropIfExists('gc_programa_servicio_social');
        Schema::dropIfExists('gc_atencion_grupos_poblacionales');

        // Eliminar tabla gestion_comunidad
        Schema::dropIfExists('gestion_comunidad');
    }
};
