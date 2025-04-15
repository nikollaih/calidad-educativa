<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionAdministrativaTable extends Migration
{
    public function up(): void
    {
        Schema::create('gestion_administrativa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institucions');

            $table->text('proceso_matricula')->nullable();
            $table->string('anexo_acto_administrativo_proceso_matricula')->nullable();

            $table->text('sistema_informacion_academica')->nullable();

            $table->text('mantenimiento_infraestructura')->nullable();
            $table->string('anexo_mantenimiento_infraestructura')->nullable();

            $table->text('dotacion_recursos_aprendizaje')->nullable();
            $table->string('anexo_dotacion_recursos')->nullable();

            $table->text('programas_seguridad')->nullable();
            $table->text('estrategias_acceso_permanencia')->nullable();
            $table->text('perfiles_asignacion')->nullable();

            $table->text('programa_formacion_capacitacion')->nullable();
            $table->string('anexo_programa_formacion')->nullable();

            $table->text('pertenencia_personal')->nullable();
            $table->text('evaluacion_desempeno')->nullable();
            $table->string('anexo_informe_anual')->nullable();
            $table->text('convivencia_manejo_conflictos')->nullable();

            $table->text('presupuesto_fse')->nullable();
            $table->string('anexo_presupuesto_fse')->nullable();
            
            $table->text('contabilidad')->nullable();
            $table->text('contratacion')->nullable();
            $table->string('anexo_manual_contratacion')->nullable();
            $table->text('control_fiscal')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestion_administrativa');
    }
}
