<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_subprocesos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descripcion');
            $table->unsignedBigInteger('proceso_id');

            $table->foreign('proceso_id')
                ->references('id')
                ->on('pam_procesos');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_subprocesos');
    }
};