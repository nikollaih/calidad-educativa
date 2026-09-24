<?php

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
        Schema::table('pam_componentes', function (Blueprint $table) {
            $table->unsignedBigInteger('componente_id')->nullable()->after('descripcion');

            $table->dropColumn(['nombre', 'descripcion']);

            $table->foreign('componente_id')
                  ->references('id')
                  ->on('componentes')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pam_componentes', function (Blueprint $table) {
            $table->dropForeign(['componente_id']);

            $table->dropColumn(['componente_id']);
        });
    }
};
