<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('pmi_comentario_factors', function (Blueprint $table) {
            $table->id();
            $table->text('comentario')
                ->nullable(false)
                ->comment("ALMACENA EL COMENTARIO SOBRE EL FACTOR CRITICO");
            $table->string('estado')
                ->nullable(false)
                ->comment("ES EL ESTADO DEL COMENTARIO");

            $table->unsignedBigInteger('factor_id')
                ->nullable(false)
                ->comment("FACTOR CRITICO QUE SE ESTA COMENTANDO");

            $table->unsignedBigInteger('pmi_id')
                ->nullable(false)
                ->comment("PMI QUE CONTIENE EL FACTOR CRITICO QUE SE ESTA COMENTANDO");

            $table->unsignedBigInteger('autor_id')
                ->nullable(false)
                ->comment("ID DE QUIEN HACE EL COMENTARIO");

            $table->foreign('factor_id')
               ->references('id')
               ->on('factor_criticos')
               ->onDelete('cascade');

            $table->foreign('pmi_id')
               ->references('id')
               ->on('pmis')
               ->onDelete('cascade');

            $table->foreign('autor_id')
               ->references('id')
               ->on('users')
               ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('pmi_comentario_factors');
    }
};
