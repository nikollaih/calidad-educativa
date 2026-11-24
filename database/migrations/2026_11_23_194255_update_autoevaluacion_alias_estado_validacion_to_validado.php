<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('autoevaluacions')
            ->where('alias_estado', 'VALIDACION')
            ->update(['alias_estado' => 'VALIDADO']);
    }

    public function down(): void
    {
        DB::table('autoevaluacions')
            ->where('alias_estado', 'VALIDADO')
            ->update(['alias_estado' => 'VALIDACION']);
    }
};
