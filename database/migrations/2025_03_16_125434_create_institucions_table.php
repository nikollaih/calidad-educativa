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
        Schema::create('institucions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nit');
            $table->string('dane');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('web_url')->nullable();
            $table->string('nombre_rector')->nullable();
            $table->string('nombre_coordinadores')->nullable();
            $table->foreignId('licencia_funcionamiento')->constrained('adjuntos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucions');
    }
};
