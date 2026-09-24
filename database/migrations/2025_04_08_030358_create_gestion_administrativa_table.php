<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla principal: gestion_administrativa
        Schema::create('gestion_administrativa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institucions')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla para Apoyo a la Gestión Académica
        Schema::create('gad_apoyo_gestion_academica', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_administrativa_id')->primary();
            $table->text('proceso_matricula')->nullable();
            $table->unsignedBigInteger('anexo_acto_administrativo_proceso_matricula')->nullable();
            $table->text('sistema_informacion_academica')->nullable();
            
            $table->foreign('anexo_acto_administrativo_proceso_matricula', 'anexo_acto_a_pma')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('gestion_administrativa_id')->references('id')->on('gestion_administrativa')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla para Administración de Planta Física
        Schema::create('gad_administracion_planta_fisica', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_administrativa_id')->primary();
            $table->text('mantenimiento_infraestructura')->nullable();
            $table->unsignedBigInteger('anexo_mantenimiento_infraestructura')->nullable();
            $table->text('dotacion_recursos_aprendizaje')->nullable();
            $table->unsignedBigInteger('anexo_dotacion_recursos')->nullable();
            $table->text('programas_seguridad')->nullable();
            
            $table->foreign('anexo_mantenimiento_infraestructura', 'anexo_manten_infraes')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_dotacion_recursos')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('gestion_administrativa_id', 'apf_ga_fk')->references('id')->on('gestion_administrativa')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla para Servicios Complementarios
        Schema::create('gad_servicios_complementarios', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_administrativa_id')->primary();
            $table->text('estrategias_acceso_permanencia')->nullable();
            
            $table->foreign('gestion_administrativa_id')->references('id')->on('gestion_administrativa')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla para Talento Humano
        Schema::create('gad_talento_humano', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_administrativa_id')->primary();
            $table->text('perfiles_asignacion')->nullable();
            $table->text('programa_formacion_capacitacion')->nullable();
            $table->unsignedBigInteger('anexo_programa_formacion')->nullable();
            $table->text('pertenencia_personal')->nullable();
            $table->text('evaluacion_desempeno')->nullable();
            $table->unsignedBigInteger('anexo_informe_anual')->nullable();
            $table->text('convivencia_manejo_conflictos')->nullable();
            
            $table->foreign('anexo_programa_formacion')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_informe_anual')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('gestion_administrativa_id')->references('id')->on('gestion_administrativa')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla para Apoyo Financiero y Contable
        Schema::create('gad_apoyo_financiero_contable', function (Blueprint $table) {
            $table->unsignedBigInteger('gestion_administrativa_id')->primary();
            $table->text('presupuesto_fse')->nullable();
            $table->unsignedBigInteger('anexo_presupuesto_fse')->nullable();
            $table->text('contabilidad')->nullable();
            $table->text('contratacion')->nullable();
            $table->unsignedBigInteger('anexo_manual_contratacion')->nullable();
            $table->text('control_fiscal')->nullable();
            
            $table->foreign('anexo_presupuesto_fse')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('anexo_manual_contratacion')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('gestion_administrativa_id')->references('id')->on('gestion_administrativa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gad_apoyo_financiero_contable');
        Schema::dropIfExists('gad_talento_humano');
        Schema::dropIfExists('gad_servicios_complementarios');
        Schema::dropIfExists('gad_administracion_planta_fisica');
        Schema::dropIfExists('gad_apoyo_gestion_academica');

        // Finalmente eliminar la tabla principal
        Schema::dropIfExists('gestion_administrativa');
    }
};
