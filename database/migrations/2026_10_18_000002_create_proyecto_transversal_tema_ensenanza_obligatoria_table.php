<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyecto_transversal_tema_ensenanza_obligatoria', function (Blueprint $table) {
            $table->unsignedInteger('proyecto_transversal_id');
            $table->unsignedInteger('tema_ensenanza_obligatoria_id');
            $table->timestamps();

            $table->primary(['proyecto_transversal_id', 'tema_ensenanza_obligatoria_id']);
            $table->foreign('proyecto_transversal_id', 'ptteo_proyecto_fk')
                ->references('id')
                ->on('proyectos_transversales')
                ->onDelete('cascade');
            $table->foreign('tema_ensenanza_obligatoria_id', 'ptteo_tema_fk')
                ->references('id')
                ->on('temas_ensenanza_obligatoria')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto_transversal_tema_ensenanza_obligatoria');
    }
};
