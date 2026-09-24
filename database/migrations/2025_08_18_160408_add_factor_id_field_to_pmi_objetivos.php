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
        Schema::table('pmi_objetivos', function (Blueprint $table) {
            $table->unsignedBigInteger('factor_id')
                ->nullable(false)
                ->after('descripcion');

            $table->foreign('factor_id')
                ->references('id')
                ->on('factor_critico_calificacions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_objetivos', function (Blueprint $table) {
            $table->dropForeign(['factor_id']);
            $table->dropColumn('factor_id');
        });
    }
};
