<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pmi_meta_vinculadas', function (Blueprint $table) {
            // Elimina la clave foránea y las columnas
            if (Schema::hasColumn('pmi_meta_vinculadas', 'indicador_id')) {
                $table->dropForeign(['indicador_id']);
                $table->dropColumn('indicador_id');
            }

            if (Schema::hasColumn('pmi_meta_vinculadas', 'valor_requerido')) {
                $table->dropColumn('valor_requerido');
            }

            if (Schema::hasColumn('pmi_meta_vinculadas', 'indicador')) {
                $table->dropColumn('indicador');
            }
        });
    }

    public function down(): void {
        Schema::table('pmi_meta_vinculadas', function (Blueprint $table) {
            // Restaurar columnas eliminadas
            $table->unsignedBigInteger('indicador_id')->after('descripcion');
            $table->integer('valor_requerido')->comment('EL VALOR REQUERIDO PARA DARSE POR COMPLETADA LA META')->after('objetivo_id');
            $table->integer('indicador')->default(0)->comment('ES EL INDICADOR, ES DECIR EL ENTERO DE COMPLETITUD')->after('valor_requerido');

            // Restaurar la clave foránea eliminada
            $table->foreign('indicador_id')
                  ->references('id')
                  ->on('pmi_indicadors')
                  ->onDelete('cascade');
        });
    }
};

