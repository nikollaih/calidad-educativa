<?php

use App\Models\Enums\PamEstadoEnum;
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
        Schema::table('redes_integrantes', function (Blueprint $table) {
            $table->unsignedBigInteger('institucion_id')->nullable()->after('red_aprendizaje_id');

            $table->foreign('institucion_id')->references('id')->on('institucions')->onDelete('no action');
        });
        Schema::table('proyecto_integrantes', function (Blueprint $table) {
            $table->unsignedBigInteger('institucion_id')->nullable()->after('proyecto_transversal_id');

            $table->foreign('institucion_id')->references('id')->on('institucions')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redes_integrantes', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            $table->dropColumn('institucion_id');
        });

        Schema::table('proyecto_integrantes', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            $table->dropColumn('institucion_id');
        });
    }
};
