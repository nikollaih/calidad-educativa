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
        Schema::create('pmis', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')
            ->nullable();
            $table->year('anio_inicio');
            $table->year('anio_fin');
            $table->unsignedBigInteger('autoevaluacion_id')
                ->unique()
                ->comment("ID DE LA AUTOEVALUACION A LA QUE PERTENECE");
            $table->foreign('autoevaluacion_id')
                ->references('id')
                ->on('autoevaluacions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmis');
    }
};
