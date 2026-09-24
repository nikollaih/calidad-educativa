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
        Schema::create('sede_infraestructuras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment("NOMBRE DEL ELEMENTO DE INFRAESTRUCTURA");
            $table->integer('cantidad')->nullable()->comment("CANTIDAD DE ELEMENTOS");
            $table->boolean('tiene_cantidad')->default(true);
            $table->double('area')->comment("AREA DEL ELEMENTO");
            $table->unsignedBigInteger('sede_id')->nullable()->comment("ID DE LA SEDE QUE REPRESENTA");
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sede_infraestructuras');
    }
};
