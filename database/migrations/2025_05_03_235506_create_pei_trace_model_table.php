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
        Schema::create('pei_historial', function (Blueprint $table) {
            $table->id();
            
            // Campos polimórficos para relacionar con cualquier modelo
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            
            // Relación con adjuntos (opcional, manteniendo tu estructura original)
            $table->foreignId('attachment_id')->nullable()->constrained('adjuntos')->nullOnDelete();
            
            $table->unsignedTinyInteger('tipo_codificacion')->nullable();
            $table->dateTime('date')->nullable();
            $table->text('observation')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejorar búsquedas polimórficas
            $table->index(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pei_historial');
    }
};