<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('pmi_metas', function (Blueprint $table) {
            $table->dropForeign(['indicador_id']);
            $table->dropColumn('indicador_id');
            $table->dropColumn('valor_requerido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('pmi_metas', function (Blueprint $table) {
           $table->integer('valor_requerido');
        });
    }
};
