<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::table('pam', function (Blueprint $table) {
            $table->year('anio_inicio');
            $table->year('anio_fin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::table('pam', function (Blueprint $table) {
            $table->dropColumn(['anio_inicio','anio_fin']);
        });
    }
};