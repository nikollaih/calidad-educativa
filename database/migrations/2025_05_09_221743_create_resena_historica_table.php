<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear tabla resena_historica
        Schema::create('resena_historica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institucions')->onDelete('cascade');
            $table->timestamps();
        });

        // Crear tabla gc_atencion_grupos_poblacionales
        Schema::create('rh_resena_historica', function (Blueprint $table) {
            $table->unsignedBigInteger('resena_historica_id')->primary();
            $table->text('resena_historica')->nullable();
            $table->foreign('resena_historica_id')->references('id')->on('resena_historica')->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('rh_resena_historica');

        // Eliminar tabla resena_historica
        Schema::dropIfExists('resena_historica');
    }
};
