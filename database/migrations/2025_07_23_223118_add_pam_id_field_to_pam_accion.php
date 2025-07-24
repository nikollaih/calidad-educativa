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
        Schema::table('pam_acciones', function (Blueprint $table) {
            $table->unsignedBigInteger('pam_id')
                ->nullable()->after('user_id');

            $table->foreign('pam_id')
                ->references('id')
                ->on('pam')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pam_acciones', function (Blueprint $table) {
            $table->dropForeign(['pam_id']);

            $table->dropColumn('pam_id');
        });
    }
};
