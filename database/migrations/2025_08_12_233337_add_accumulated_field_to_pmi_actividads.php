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
        Schema::table('pmi_actividads', function (Blueprint $table) {
            $table->integer("accumulated")
                ->nullable(false)
                ->default(0)
                ->comment("EL ACUMULADO QUE GENERA EL COMPLETAR ESTA ACTIVIDAD");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_actividads', function (Blueprint $table) {
            $table->dropColumn('accumulated');
        });
    }
};
