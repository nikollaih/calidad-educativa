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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('indicador_id');
            $table->text('nombre_responsable')->nullable();
            $table->text('descripcion');
            $table->text('recursos');
            $table->date('fecha_inicio');
            $table->date('fecha_final');

            $table->foreign('indicador_id')
                ->references('id')
                ->on('pam_indicadores');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_acciones');
    }
};