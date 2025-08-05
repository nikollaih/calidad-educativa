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
            try {
                $table->dropForeign(['objetivo_id']);
            } catch (Exception $e) {
                // Si la clave foránea no existe, continúa sin error
            }

            try {
                $table->dropColumn('objetivo_id');
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
        //
    }
};
