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
        Schema::create('pmi_actividad_vinculadas', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->decimal('peso', 5, 2);
            $table->string('responsables');
            $table->decimal('recursos', 15, 2)->nullable();
            $table->date('fecha_inicio'); // Campo fecha inicio (not null)
            $table->date('fecha_fin');    // Campo fecha fin (not null)
            $table->unsignedBigInteger('meta_id');

            $table->foreign('meta_id')
                ->references('id')
                ->on('pmi_meta_vinculadas')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmi_actividad_vinculadas');
    }
};
