<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PMI\ActividadEstadoEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->string('slug_estado')->nullable()->default(ActividadEstadoEnum::SIN_INICIAR->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->dropColumn('slug_estado');
        });
    }
};
