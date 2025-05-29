<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_indicadores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('meta_id');
            $table->text('text');

            $table->foreign('meta_id')->references('id')->on('pam_metas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_indicadores');
    }
};