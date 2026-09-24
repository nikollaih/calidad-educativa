<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('pmi_indicador_vinculados', function (Blueprint $table) {
            $table->id();
            $table->string('unidad_total')
                ->nullable(false)
                ->comment('ES LA UNIDAD TOTAL DEL INDICADOR');
            $table->string('unidad_parcial')
                ->nullable(false)
                ->comment('ES LA UNIDAD PARCIAL DEL INDICADOR');
            $table->integer("valor_requerido")
                ->nullable(false)
                ->comment("EL VALOR REQUERIDO PARA DARSE POR COMPLETADO EL INDICADOR  UNIDAD TOTAL ");
            $table->integer("valor_obtenido")
                ->nullable(false)
                ->default(0)
                ->comment("ES EL INDICADOR, ES DECIR EL ENTERO DE COMPLETITUD UNIDAD PARCIAL");
            $table->unsignedBigInteger('meta_id');
            $table->foreign('meta_id')
                ->references('id')
                ->on('pmi_meta_vinculadas')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('pmi_indicador_vinculados');
    }
};
