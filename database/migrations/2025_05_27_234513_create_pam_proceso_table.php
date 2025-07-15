<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam_procesos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descripcion');
            $table->unsignedBigInteger('componente_id');

            $table->foreign('componente_id')
                ->references('id')
                ->on('pam_componentes');
                
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam_procesos');
    }
};