<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('sedes', function (Blueprint $table) {
            $table->string('state_slug')->default('abierta')->index();
        });

        Schema::create('sede_state_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained('sedes')->cascadeOnDelete();
            $table->string('state_slug');
            $table->foreignId('administrative_act_id')->constrained('adjuntos');
            $table->text('observation');
            $table->timestamps();
            $table->index(['sede_id', 'created_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('sede_state_changes');

        Schema::table('sedes', function (Blueprint $table) {
            $table->dropIndex(['state_slug']);
            $table->dropColumn('state_slug');
        });
    }
};
