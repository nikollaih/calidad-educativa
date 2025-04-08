<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('autoevaluacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institucionId')->comment('EL ID DE LA INSTITUCION');
            $table->string("alias_estado")->comment("ES EL ESTADO DE LA AUTOEVALUACION");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autoevaluacions');
    }
};
