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
        // Se modificaron los tipos de columnas para usar el sistema de tipado de Laravel (unsignedBigInteger y unsignedInteger).
        // Se agregaron las columnas de `timestamps()`.
        Schema::create('redes_aprendizaje', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('acto_administrativo_id')->comment('relacion con adjuntos');
            $table->unsignedBigInteger('representante_id')->comment('relacion con users');
            $table->string('nombre');
            $table->string('correo');
            $table->text('descripcion')->nullable();
            $table->string('numero_contacto', 15);
            $table->timestamps();

            $table->foreign('acto_administrativo_id')->references('id')->on('adjuntos')->onDelete('no action');
            $table->foreign('representante_id')->references('id')->on('users')->onDelete('no action');
        });

        // Se modificó para usar unsignedInteger y se agregó onDelete('cascade').
        Schema::create('redes_integrantes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('red_aprendizaje_id');
            $table->string('nombre');
            $table->string('telefono', 15)->nullable();
            $table->string('correo')->nullable();
            $table->unsignedTinyInteger('rol')->comment('Los roles ya estan definidos en el sistema');
            $table->timestamps();
            
            $table->foreign('red_aprendizaje_id')->references('id')->on('redes_aprendizaje')->onDelete('cascade');
        });


        // Se modificó para usar unsignedInteger y se agregó onDelete('cascade').
        Schema::create('redes_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('red_aprendizaje_id');
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('red_aprendizaje_id')->references('id')->on('redes_aprendizaje')->onDelete('cascade');
        });

        // Se modificó para usar unsignedBigInteger y unsignedInteger, y se agregaron las relaciones.
        Schema::create('redes_actividades_has_adjuntos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('red_actividad_id');
            $table->unsignedBigInteger('adjunto_id')->comment('Relacion con adjuntos');
            $table->timestamps();
            
            $table->foreign('red_actividad_id')->references('id')->on('redes_actividades')->onDelete('cascade');
            $table->foreign('adjunto_id')->references('id')->on('adjuntos')->onDelete('no action');
        });

        // Se modificó para usar unsignedBigInteger y se agregaron las relaciones.
        Schema::create('proyectos_transversales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('institucion_id')->comment('Relacion con instituciones');
            $table->unsignedBigInteger('acto_administrativo_id')->comment('relacion con adjuntos');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('numero_contacto', 15);
            $table->timestamps();
            
            $table->foreign('institucion_id')->references('id')->on('institucions')->onDelete('no action');
            $table->foreign('acto_administrativo_id')->references('id')->on('adjuntos')->onDelete('no action');
        });

        // Se modificó para usar unsignedInteger y se agregó onDelete('cascade').
        Schema::create('proyectos_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('proyecto_transversal_id');
            $table->dateTime('fecha');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('proyecto_transversal_id')->references('id')->on('proyectos_transversales')->onDelete('cascade');
        });
        
        // Se modificó para usar unsignedBigInteger y unsignedInteger, y se agregaron las relaciones.
        Schema::create('proyectos_actividades_has_adjuntos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('proyecto_actividad_id');
            $table->unsignedBigInteger('adjunto_id')->comment('Relacion con adjuntos');
            $table->timestamps();

            $table->foreign('proyecto_actividad_id')->references('id')->on('proyectos_actividades')->onDelete('cascade');
            $table->foreign('adjunto_id')->references('id')->on('adjuntos')->onDelete('no action');
        });

        Schema::create('proyecto_integrantes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('proyecto_transversal_id');
            $table->string('nombre');
            $table->string('telefono', 15)->nullable();
            $table->string('correo')->nullable();
            $table->unsignedTinyInteger('rol')->comment('Los roles ya estan definidos en el sistema');
            $table->timestamps();
            
            $table->foreign('proyecto_transversal_id')->references('id')->on('proyectos_transversales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    // Eliminar primero las tablas que tienen claves foráneas hacia otras tablas
    Schema::dropIfExists('redes_actividades_has_adjuntos');
    Schema::dropIfExists('proyectos_actividades_has_adjuntos');
    Schema::dropIfExists('redes_actividades');
    Schema::dropIfExists('proyectos_actividades');
    Schema::dropIfExists('redes_integrantes');
    Schema::dropIfExists('proyecto_integrantes');
    Schema::dropIfExists('redes_aprendizaje');
    Schema::dropIfExists('proyectos_transversales');
}
};
