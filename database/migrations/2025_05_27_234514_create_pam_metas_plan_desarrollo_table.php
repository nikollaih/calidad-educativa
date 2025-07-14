<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('pam_metas_plan_desarrollo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descripcion');
            $table->unsignedBigInteger('subproceso_id');
            $table->unsignedBigInteger('objetivo_estrategico_id');

            $table->foreign('objetivo_estrategico_id')
                ->references('id')
                ->on('pam_objetivos_estrategicos');

            $table->foreign('subproceso_id')
                ->references('id')
                ->on('pam_subprocesos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('pam_metas_plan_desarrollo');
    }
};