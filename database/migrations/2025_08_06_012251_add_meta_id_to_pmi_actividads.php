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
            $table->unsignedBigInteger('meta_id')
                ->nullable()
                ->after('descripcion');

            $table->foreign('meta_id')
                ->references('id')
                ->on('pmi_metas')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_actividads', function (Blueprint $table) {
                $table->dropForeign(['meta_id']);
                $table->dropColumn('meta_id');
        });
    }
};
