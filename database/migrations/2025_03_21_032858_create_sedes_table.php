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
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("es el nombre de la sede");
            $table->string("dane")->comment("representa el dane de la sede");
            $table->string("address")->nullable()->comment("direccion de la sede");
            $table->string("zone")->nullable()->comment("zona de la sede");
            //ubicacion gps
            $table->text("latitude");
            $table->text("longitude");
            $table->boolean("is_new_school")->default(false);
            $table->unsignedBigInteger('institution_id')->comment("id de la institucion");
            $table->unsignedBigInteger('administrative_act')->nullable()->comment("acto administrativo");
            $table->unsignedBigInteger('parent_sede_id')->nullable()->comment("indica si es adscrita o principal");
            $table->foreign('parent_sede_id')->references('id')->on('sedes')->nullOnDelete();
            $table->foreign('administrative_act')->references('id')->on('adjuntos')->nullOnDelete();
            $table->foreign('institution_id')->references('id')->on('institucions');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->dropForeign(['parent_sede_id']);
            $table->dropForeign(['administrative_act']);
            $table->dropForeign(['institution_id']);
        });
        Schema::dropIfExists('sedes');
    }
};
