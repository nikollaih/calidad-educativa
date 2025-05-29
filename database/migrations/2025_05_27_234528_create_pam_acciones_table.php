<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_acciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('indicador_id');
            $table->text('text');
            $table->boolean('estado');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            // $table->timestamps();

            $table->foreign('indicador_id')->references('id')->on('pam_indicadores');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_acciones');
    }
};