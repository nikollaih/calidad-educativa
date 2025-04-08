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
        Schema::create('educational_offers', function (Blueprint $table) {
            $table->id();
            $table->boolean("has_study_validation_auth")->default(false);
            $table->boolean("serves_juvenile_justice")->default(false);
            $table->boolean("national_protection_students")->default(false);
            $table->boolean("serves_ethnic_population")->default(false);
            $table->unsignedBigInteger('validation_authorization')->nullable()->comment("Archivo de autorizacion para validaciones de estudios");
            $table->unsignedBigInteger('sede_id')->nullable()->comment("Sede a la que se ofrece la oferta educativa");
            $table->foreign('validation_authorization')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('sede_id')->references('id')->on('sedes')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_offers');
    }
};
