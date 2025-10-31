
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            // 1️⃣ Crear columna temporalmente como NULLABLE
            $table->unsignedBigInteger('indicador_id')
                ->nullable()
                ->after('indicador_acumulado');
        });

        // 2️⃣ Eliminar registros sin indicador_id
        DB::table('pmi_actividad_vinculadas')
            ->whereNull('indicador_id')
            ->delete();

        // 3️⃣ Convertir la columna a NOT NULL y agregar la foránea
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->unsignedBigInteger('indicador_id')
                ->nullable(false)
                ->change();

            $table->foreign('indicador_id')
                ->references('id')
                ->on('pmi_indicador_vinculados')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            if (Schema::hasColumn('pmi_actividad_vinculadas', 'indicador_id')) {
                // Eliminar primero la foreign key
                $table->dropForeign(['indicador_id']);

                // Luego eliminar la columna
                $table->dropColumn('indicador_id');
            }
        });
    }
};

