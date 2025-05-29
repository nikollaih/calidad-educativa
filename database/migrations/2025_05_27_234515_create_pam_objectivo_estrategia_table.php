<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_objetivo_estrategico', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('text');
            $table->unsignedBigInteger('pam_componente_id');
            // $table->timestamps();

            $table->foreign('pam_componente_id')->references('id')->on('pam_has_componentes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_objetivo_estrategico');
    }
};