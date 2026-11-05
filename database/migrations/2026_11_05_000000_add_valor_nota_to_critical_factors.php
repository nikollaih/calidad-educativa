<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factor_critico_calificacions', function (Blueprint $table) {
            $table->unsignedTinyInteger('valor_nota')
                ->nullable()
                ->after('indice_calificacion')
                ->comment('Valor de NotaCalificacion que determina el tipo del factor crítico');
        });

        Schema::table('factor_criticos', function (Blueprint $table) {
            $table->unsignedTinyInteger('valor_nota')
                ->nullable()
                ->after('calificacion_indice')
                ->comment('Valor de NotaCalificacion que determinó este factor crítico');
        });
    }

    public function down(): void
    {
        Schema::table('factor_criticos', function (Blueprint $table) {
            $table->dropColumn('valor_nota');
        });

        Schema::table('factor_critico_calificacions', function (Blueprint $table) {
            $table->dropColumn('valor_nota');
        });
    }
};
