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
        Schema::create('educational_offer_model', function (Blueprint $table) {
            $table->foreignId('educational_offer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('educational_model_id')->constrained()->cascadeOnDelete();
            $table->primary(['educational_offer_id', 'educational_model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_offer_model');
    }
};
