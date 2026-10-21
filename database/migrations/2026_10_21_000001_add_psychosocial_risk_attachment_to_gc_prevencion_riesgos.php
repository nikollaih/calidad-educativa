<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gc_prevencion_riesgos', function (Blueprint $table) {
            $table->unsignedBigInteger('anexo_prevencion_riesgos_psicosociales_id')->nullable();
            $table->foreign(
                'anexo_prevencion_riesgos_psicosociales_id',
                'gc_prev_riesgos_psicosoc_adj_fk'
            )->references('id')->on('adjuntos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gc_prevencion_riesgos', function (Blueprint $table) {
            $table->dropForeign('gc_prev_riesgos_psicosoc_adj_fk');
            $table->dropColumn('anexo_prevencion_riesgos_psicosociales_id');
        });
    }
};
