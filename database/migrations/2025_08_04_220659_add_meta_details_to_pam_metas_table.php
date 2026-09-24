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
        Schema::table('pam_metas', function (Blueprint $table) {
            $table->float('valor_meta')->nullable()->after('descripcion');
            $table->unsignedBigInteger('unidad_meta_id')->nullable()->after('valor_meta');

            $table->foreign('unidad_meta_id')
                  ->references('id')
                  ->on('unidades_meta')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pam_metas', function (Blueprint $table) {
            $table->dropForeign(['unidad_meta_id']);

            $table->dropColumn(['valor_meta', 'unidad_meta_id']);
        });
    }
};
