<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('objetivo_strategico_id');
            $table->text('text');

            $table->foreign('objetivo_strategico_id')->references('id')->on('pam_objetivo_estrategico');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_metas');
    }
};