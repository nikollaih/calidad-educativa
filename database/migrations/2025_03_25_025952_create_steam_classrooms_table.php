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
        Schema::create('steam_classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('phase');
            $table->integer('quantity');
            $table->unsignedBigInteger('sede_id')->nullable()->comment("ID DE LA SEDE QUE REPRESENTA");
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('steam_classrooms', function (Blueprint $table) {
            $table->dropForeign(['sede_id']);
        });
        Schema::dropIfExists('steam_classrooms');
    }
};
