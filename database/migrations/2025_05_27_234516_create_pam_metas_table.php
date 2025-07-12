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
            $table->text('descripcion');

        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_metas');
    }
};