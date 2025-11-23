<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->string('frecuencia_recoleccion')
                ->comment("HACE REFERENCIA A LA PERIOCIDAD DE CREACION DE AVANCES DE LA ACTIVIDAD")
                ->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->dropColumn('frecuencia_recoleccion');
        });
    }
};
