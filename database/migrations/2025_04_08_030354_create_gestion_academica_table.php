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
            
            // Apoyo a la gestión académica
            $table->text('proceso_matricula');
            $table->string('anexo_proceso_matricula')->nullable();
            $table->text('sistema_informacion_academica');
            
            // Administración de la planta física y recursos
            $table->text('mantenimiento_infraestructura');
            $table->string('anexo_mantenimiento_infraestructura')->nullable();
            $table->text('dotacion_recursos_aprendizaje');
            $table->string('anexo_dotacion_recursos')->nullable();
            $table->text('programas_seguridad');
            
            // Servicios Complementarios
            $table->text('estrategias_acceso_permanencia');
            
            // Talento humano
            $table->text('perfiles_asignacion');
            $table->text('programa_formacion_capacitacion');
            $table->string('anexo_programa_formacion')->nullable();
            $table->text('pertenencia_personal');
            $table->text('evaluacion_desempeno');
            $table->text('convivencia_manejo_conflictos');
            
            // Apoyo financiero y contable
            $table->text('presupuesto_fse');
            $table->string('anexo_presupuesto_fse')->nullable();
            $table->text('contabilidad');
            $table->text('contratacion');
            $table->text('control_fiscal');
            
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
