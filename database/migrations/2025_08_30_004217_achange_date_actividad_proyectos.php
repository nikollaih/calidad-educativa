<?php

use App\Models\Enums\PamEstadoEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PMI\Enums\PmiEstadoEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proyectos_actividades', function (Blueprint $table) {
            $table->date('fecha')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pam', function (Blueprint $table) {
            //
        });
    }
};
