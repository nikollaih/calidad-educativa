<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            // Elimina la clave foránea y las columnas
            if (Schema::hasColumn('pmi_actividad_vinculadas', 'meta_id')) {
                $table->dropForeign(['meta_id']);
                $table->dropColumn('meta_id');
            }
        });
    }

    public function down(): void {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            // Restaurar columnas eliminadas
            $table->unsignedBigInteger('indicador_id')->after('fecha_fin');
            $table->foreign('meta_id')
                            ->references('id')
                            ->on('pmi_meta_vinculadas')
                            ->onDelete('cascade');
        });
    }
};

