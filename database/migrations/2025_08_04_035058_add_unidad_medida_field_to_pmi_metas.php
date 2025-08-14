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
        Schema::table('pmi_metas', function (Blueprint $table) {
            $table->string("unidad_medida")
                ->nullable(false)
                ->comment("UNIDAD DE MEDIDA DE LA META EJEM CANTIDAD DE INSTITUCIONES MEJORADAS");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_metas', function (Blueprint $table) {
            $table->dropColumn('unidad_medida');
        });
    }
};
