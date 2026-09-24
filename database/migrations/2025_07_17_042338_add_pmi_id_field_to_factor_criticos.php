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
        Schema::table('factor_criticos', function (Blueprint $table) {
            $table->unsignedBigInteger('pmi_id')
                ->nullable();

            // Crear la foreign key constraint
            $table->foreign('pmi_id')
                ->references('id')
                ->on('pmis')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factor_criticos', function (Blueprint $table) {
            //
        });
    }
};
