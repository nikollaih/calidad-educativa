<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_has_sedes', function (Blueprint $table) {
            $table->unsignedBigInteger('pam_id');
            $table->unsignedBigInteger('sede_id');
            $table->primary(['pam_id', 'sede_id']);

            $table->foreign('pam_id')->references('id')->on('pam');
            $table->foreign('sede_id')->references('id')->on('sedes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_has_sedes');
    }
};