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
        Schema::create('grupo_calificacions', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->comment("es el nombre del grupo de calificaciones");
            $table->string("indice")->unique()->comment("es el indice del grupo de calificaciones");
            $table->unsignedBigInteger('padre_id')->nullable()->comment("es el id del  grupo de calificaciones padre");

            $table->foreign('padre_id')->references('id')->on('grupo_calificacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_calificacions');
    }
};
