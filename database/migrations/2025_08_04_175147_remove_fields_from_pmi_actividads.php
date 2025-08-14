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
        Schema::table('pmi_actividads', function (Blueprint $table) {
            try {
                $table->dropColumn('responsables');
                $table->dropColumn('recursos');

            } catch (Exception $e) {
                // Si la columna no existe, continúa sin error
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_actividads', function (Blueprint $table) {
            //
        });
    }
};
