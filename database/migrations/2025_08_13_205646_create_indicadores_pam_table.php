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
        Schema::table('unidades_meta', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'descripcion']);
            $table->string('unidad_parcial')->after('id');
            $table->string('unidad_total')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unidades_meta', function (Blueprint $table) {
            $table->dropColumn(['unidad_parcial', 'unidad_total']);
            $table->string('codigo')->after('id');
            $table->string('descripcion')->after('codigo');
        });
    }
};