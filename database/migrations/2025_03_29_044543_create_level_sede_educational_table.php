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

            $table->unsignedBigInteger('educational_level_id');
            $table->unsignedBigInteger('educational_shedule_id');
            $table->unsignedBigInteger('sede_educational_offer_id');

            $table->primary(['educational_level_id', 'sede_educational_offer_id','educational_shedule_id']);

            $table->foreign('educational_level_id')->references('id')->on('educational_offer_levels')->onDelete('cascade');
            $table->foreign('educational_shedule_id')->references('id')->on('educational_offer_schedules')->onDelete('cascade');
            $table->foreign('sede_educational_offer_id')->references('id')->on('sede_educational_offers')->onDelete('cascade');

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
