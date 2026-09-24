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
        Schema::table('pmi_indicadors', function (Blueprint $table) {
            $table->dropForeign(['meta_id']);
        });

        Schema::dropIfExists('pmi_indicadors');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
