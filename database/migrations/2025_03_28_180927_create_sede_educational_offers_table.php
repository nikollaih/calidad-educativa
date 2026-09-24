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
        Schema::create('sede_educational_offers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sede_id');
            $table->unsignedBigInteger('educational_offer_id');

            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
            $table->foreign('educational_offer_id')->references('id')->on('educational_offers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sede_educational_offers');
    }
};
