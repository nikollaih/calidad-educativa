<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('institucions', function (Blueprint $table) {
            $table->unsignedBigInteger('rector_id')
                ->nullable(true)
                ->after('licencia_funcionamiento');

            $table->foreign('rector_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('institucions', function (Blueprint $table) {
            $table->dropForeign(['rector_id']);
            $table->dropColumn('rector_id');
        });
    }
};
