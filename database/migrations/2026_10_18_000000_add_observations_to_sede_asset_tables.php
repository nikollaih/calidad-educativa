<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->text('observacion')->nullable();
        });

        Schema::table('sede_infraestructuras', function (Blueprint $table) {
            $table->text('observacion')->nullable();
        });

        Schema::table('sede_mobiliarios', function (Blueprint $table) {
            $table->text('observacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('observacion');
        });

        Schema::table('sede_infraestructuras', function (Blueprint $table) {
            $table->dropColumn('observacion');
        });

        Schema::table('sede_mobiliarios', function (Blueprint $table) {
            $table->dropColumn('observacion');
        });
    }
};
