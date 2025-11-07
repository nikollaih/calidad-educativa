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
            $table->string("instrumentos_recoleccion")
                ->nullable(true)
                ->after('responsables')
                ->comment("SON LOS INSTRUMENTOS DE RECLECCION DE LOS AVANCES");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->dropColumn('instrumentos_recoleccion');
        });
    }
};
