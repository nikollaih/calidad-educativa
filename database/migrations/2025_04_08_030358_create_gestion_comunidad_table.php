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
        Schema::create('gestion_comunidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            
            // Atención a grupos poblacionales
            $table->text('atencion_grupos_vulnerabilidad');
            $table->text('necesidades_expectativas_estudiantes');
            $table->text('proyectos_vida');
            $table->text('escuela_padres');
            $table->text('oferta_servicios_comunidad');
            
            // Programa de servicio social
            $table->string('anexo_proyecto_escuela_padres')->nullable();
            $table->text('programa_servicio_social');
            $table->string('anexo_programa_servicio_social')->nullable();
            
            // Prevención de riesgos
            $table->text('prevencion_riesgos_fisicos');
            $table->string('anexo_prevencion_riesgos_fisicos')->nullable();
            $table->text('prevencion_riesgos_psicosociales');
            
            $table->foreign('institution_id')->references('id')->on('institucions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestion_comunidad', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
        });
        Schema::dropIfExists('gestion_comunidad');
    }
};
