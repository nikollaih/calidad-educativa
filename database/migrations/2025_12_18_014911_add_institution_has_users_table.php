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
        Schema::create('institucion_user', function (Blueprint $table) {
            $table->id();

            // Llaves foráneas
            $table->foreignId('institucion_id')
                ->constrained('institucions')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Campos adicionales opcionales
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['institucion_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucion_user');
    }
};
