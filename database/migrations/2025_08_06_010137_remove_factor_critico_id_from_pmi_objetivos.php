<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            Schema::table('pmi_objetivos', function (Blueprint $table) {
                $table->dropForeign(['factor_critico_Id']);
                $table->dropColumn('factor_critico_Id');
            });

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (Exception $e) {

        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmi_objetivos', function (Blueprint $table) {
            //
        });
    }
};
