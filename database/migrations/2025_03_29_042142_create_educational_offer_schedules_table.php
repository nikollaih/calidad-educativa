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
        Schema::create('educational_offer_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('schedule');
            $table->foreignId('document_id')->constrained('adjuntos');
            $table->foreignId('sede_offer_id')->constrained('sede_educational_offers');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_offer_schedules');
    }
};
