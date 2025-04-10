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
        Schema::table('educational_offer_levels', function (Blueprint $table) {
            $table->foreignId('institution_id')
                ->after('document_id') // o después de cualquier otra columna
                ->constrained('institucions') // referencia a la tabla `institucions`
                ->onDelete('cascade'); // comportamiento al eliminar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('educational_offer_levels', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
            $table->dropColumn('institution_id');
        });
    }
};
