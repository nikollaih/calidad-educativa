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
        Schema::create('pmi_actividad_avance_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('avance_id')
                ->comment("ID DEL AVANCE");

            $table->unsignedBigInteger('file_id')
                ->nullable(true)
                ->comment("ID DEL ADJUNTO");

            $table->foreign('avance_id')
                ->references('id')
                ->on('pmi_actividad_avances')
                ->onDelete('cascade');

            $table->foreign('file_id')
                ->references('id')
                ->on('adjuntos')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmi_actividad_avance_files');
    }
};
