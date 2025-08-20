<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            // Cambiar tipo de la columna
            $table->string('recursos')->change();
        });
    }

    public function down(): void
    {
        Schema::table('pmi_actividad_vinculadas', function (Blueprint $table) {
            // Volver al tipo anterior (ejemplo: integer, text, etc.)
            $table->integer('recursos')->change();
        });
    }
};

