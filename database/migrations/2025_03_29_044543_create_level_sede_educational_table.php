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
        Schema::create('level_sede_educationals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('educational_level_id');
            $table->unsignedBigInteger('educational_shedule_id');
            $table->unsignedBigInteger('sede_id');

            $table->foreign('educational_level_id')->references('id')->on('educational_offer_levels')->onDelete('cascade');
            $table->foreign('educational_shedule_id')->references('id')->on('educational_offer_schedules')->onDelete('cascade');
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_sede_educationals');
    }
};
