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
            $table->unsignedBigInteger('objetivo_id')
                ->nullable()
                ->after('descripcion');

            $table->foreign('objetivo_id')
                ->references('id')
                ->on('pmi_objetivos')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_metas', function (Blueprint $table) {
            $table->dropForeign(['objetivo_id']);
            $table->dropColumn('objetivo_id');
        });
    }
};
