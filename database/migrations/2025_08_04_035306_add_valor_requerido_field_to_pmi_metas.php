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
            $table->integer("valor_requerido")
                ->nullable(false)
                ->comment("EL VALOR REQUERIDO PARA DARSE POR COMPLETADA LA META");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('valor_requerido', function (Blueprint $table) {
            $table->dropColumn('valor_requerido');
        });
    }
};
