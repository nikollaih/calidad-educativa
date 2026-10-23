<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HistoricalReviewMigrationTest extends TestCase
{
    public function test_migration_preserves_existing_and_large_content_on_sqlite(): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        DB::setDefaultConnection('sqlite');

        Schema::create('rh_resena_historica', function (Blueprint $table) {
            $table->unsignedBigInteger('resena_historica_id')->primary();
            $table->text('resena_historica')->nullable();
        });

        DB::table('rh_resena_historica')->insert([
            'resena_historica_id' => 1,
            'resena_historica' => 'Contenido anterior',
        ]);

        $migration = require database_path(
            'migrations/2026_10_22_000000_make_historical_review_longtext.php'
        );
        $migration->up();

        $this->assertSame(
            'Contenido anterior',
            DB::table('rh_resena_historica')->value('resena_historica')
        );

        DB::table('rh_resena_historica')->insert([
            'resena_historica_id' => 2,
            'resena_historica' => str_repeat('a', 65_536),
        ]);

        $migration->down();

        $this->assertSame(
            str_repeat('a', 65_536),
            DB::table('rh_resena_historica')
                ->where('resena_historica_id', 2)
                ->value('resena_historica')
        );
    }
}
