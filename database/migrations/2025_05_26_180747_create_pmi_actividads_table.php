<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('pmi_actividads', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->string('responsables')->nullable();
            $table->decimal('recursos', 15, 2)->nullable();
            $table->unsignedBigInteger('indicador_id');

            $table->foreign('indicador_id')
                ->references('id')
                ->on('pmi_indicadors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('pmi_actividads');
    }
};
