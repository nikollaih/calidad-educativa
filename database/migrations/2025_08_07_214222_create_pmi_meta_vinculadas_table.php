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
        Schema::create('pmi_meta_vinculadas', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->unsignedBigInteger('objetivo_id');
            $table->string("unidad_medida")
                ->nullable(false)
                ->comment("UNIDAD DE MEDIDA DE LA META EJEM CANTIDAD DE INSTITUCIONES MEJORADAS");
            $table->integer("valor_requerido")
                ->nullable(false)
                ->comment("EL VALOR REQUERIDO PARA DARSE POR COMPLETADA LA META");

            $table->foreign('objetivo_id')
                ->references('id')
                ->on('pmi_objetivo_vinculados')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmi_meta_vinculadas');
    }
};
