<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pam', function (Blueprint $table) {
            $table->id();
            $table->string('consecutivo', 45)->nullable();
            $table->unsignedTinyInteger('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pam');
    }
};