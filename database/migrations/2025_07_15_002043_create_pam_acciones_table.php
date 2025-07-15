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
        Schema::create('pam_avances', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_avance');
            $table->unsignedBigInteger('meta_id'); // Columna para la clave foránea de pam_metas
            $table->unsignedBigInteger('accion_id'); // Columna para la clave foránea de pam_acciones
            $table->integer('cantidad_ejecutada');
            $table->text('observacion')->nullable(); // Campo de texto para observaciones, puede ser nulo
            // No creamos aquí un campo directo para los archivos adjuntos.
            // Es más común manejar los archivos adjuntos en una tabla separada
            // o almacenar las rutas/nombres de archivo en un campo JSON/TEXT si son pocos.
            // Para múltiples archivos, una tabla pivot es lo ideal.

            $table->timestamps(); // created_at y updated_at

            // Definición de las claves foráneas
            $table->foreign('meta_id')
                  ->references('id')
                  ->on('pam_metas') // Asume que tu tabla de metas se llama 'pam_metas'
                  ->onDelete('cascade'); // Opcional: si la meta es eliminada, sus avances también

            $table->foreign('accion_id')
                  ->references('id')
                  ->on('pam_acciones') // Asume que tu tabla de acciones se llama 'pam_acciones'
                  ->onDelete('cascade'); // Opcional: si la acción es eliminada, sus avances también
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pam_avances');
    }
};