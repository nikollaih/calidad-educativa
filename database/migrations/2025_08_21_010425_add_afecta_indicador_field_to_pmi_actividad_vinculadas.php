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
            $table->boolean('afecta_indicador')
                ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try{
            Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
                $table->dropColumn('afecta_indicador');
            });
        } catch (\Illuminate\Database\QueryException $e){}

    }
};
