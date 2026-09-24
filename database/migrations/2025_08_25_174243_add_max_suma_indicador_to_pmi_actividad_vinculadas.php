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
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->integer('max_suma_indicador')
                ->nullable()
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->dropColumn('max_suma_indicador');
        });
    }
};
