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
        Schema::create('titularidad_sedes', function (Blueprint $table) {
            $table->id();
            $table->string('titularity_type');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('sede_id')->nullable()->comment("ID DE LA SEDE QUE REPRESENTA");
            $table->unsignedBigInteger('support_file_id')->nullable()->comment("ID DEL ADJUNTO DE SOPORTE");
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('support_file_id')->references('id')->on('adjuntos')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('titularidad_sedes', function (Blueprint $table) {
            $table->dropForeign(['sede_id']);
            $table->dropForeign(['support_file_id']);
        });
        Schema::dropIfExists('titularidad_sedes');
    }
};
