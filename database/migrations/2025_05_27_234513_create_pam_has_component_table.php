<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_has_componentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pam_id');
            $table->unsignedBigInteger('componente_id');
            $table->unsignedBigInteger('user_id');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            // $table->timestamps();

            $table->foreign('pam_id')->references('id')->on('pam');
            $table->foreign('componente_id')->references('id')->on('pam_componentes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_has_componentes');
    }
};