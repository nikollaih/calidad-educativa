<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        // Schema::table('pam_metas', function (Blueprint $table) {
        //     $table->dropForeign(['objetivo_strategico_id']);
        // });
        // Schema::table('pam_objetivo_estrategico', function (Blueprint $table) {
        //     $table->dropForeign(['pam_componente_id']);
        // });
        // Schema::table('pam_indicadores', function (Blueprint $table) {
        //     $table->dropForeign(['meta_id']);
        // });
        Schema::table('pam_acciones', function (Blueprint $table) {
            $table->dropForeign(['indicador_id']);
        });

        Schema::dropIfExists('pam_has_sedes');
        Schema::dropIfExists('pam_objetivo_estrategico');
        Schema::dropIfExists('pam_metas');
        Schema::dropIfExists('pam_has_componentes');
        Schema::dropIfExists('pam_plan_desarrollo');
        Schema::dropIfExists('pam_indicadores');
        Schema::dropIfExists('pam_acciones');
        Schema::dropIfExists('pam_componentes');
        Schema::dropIfExists('pam');

        // Tabla general del pam
        Schema::create('pam', function (Blueprint $table) {
            $table->id();
            $table->string('consecutivo', 45)->nullable();
            $table->unsignedTinyInteger('estado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla de filas del pam
        Schema::create('pam_rows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pam_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('proceso');
            $table->text('subproceso');
            $table->text('meta_plan_desarrollo');
            $table->text('objetivo_estrategico');
            $table->text('meta');
            $table->text('indicador');
            $table->text('accion');
            $table->text('recursos');
            $table->date('fecha_inicio');
            $table->date('fecha_final');

            $table->foreign('pam_id')->references('id')->on('pam')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};