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
        Schema::table('educational_offer_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('level_sede_educational_id')->nullable();

            // Crear la foreign key constraint
            $table->foreign('level_sede_educational_id')
                ->references('id')
                ->on('level_sede_educationals')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_offer_schedules', function (Blueprint $table) {
            //
        });
    }
};
