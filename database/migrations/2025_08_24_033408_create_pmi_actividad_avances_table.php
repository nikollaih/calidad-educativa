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
        Schema::create('pmi_actividad_avances', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_avance')->comment("LA FECHA QUE SE HIZO EL AVANCE");
            $table->integer('porcentaje_ejecutado')->comment("PORCENTAJE DE LA ACTIVIDAD COMPLETADO");
            $table->integer('suma_al_indicador')->comment("CANTIDAD QUE SE LE SUMA AL INDICADOR DE META");
            $table->text('descripcion')->comment("DESCRIPCION DEL AVANCE");
            $table->unsignedBigInteger('pmi_id')->comment("ID DEL PMI AL QUE PERTENECE LA META ASOCIADA AL AVANCE");
            $table->unsignedBigInteger('actividad_id')->comment("ID DE LA META ASOCIADA AL AVANCE");
            $table->foreign('pmi_id')
                ->references('id')
                ->on('pmis')
                ->onDelete('cascade');
            $table->foreign('actividad_id')
                ->references('id')
                ->on('pmi_actividad_vinculadas')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmi_actividad_avances');
    }
};
