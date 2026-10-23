<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->changeMySqlColumnType('LONGTEXT');
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        if (in_array($driver, ['sqlite', 'pgsql'], true)) {
            // These engines use unbounded TEXT; there is no smaller TEXT type to restore.
            return;
        }

        if ($driver !== 'mysql') {
            throw new RuntimeException("No se puede revertir la migración en el driver [{$driver}].");
        }

        $hasValuesTooLargeForText = DB::table('rh_resena_historica')
            ->whereRaw('OCTET_LENGTH(resena_historica) > ?', [65_535])
            ->exists();

        if ($hasValuesTooLargeForText) {
            throw new RuntimeException(
                'No se puede revertir la migración: hay reseñas de más de 65.535 bytes y convertirlas a TEXT podría truncarlas.'
            );
        }

        $this->changeMySqlColumnType('TEXT');
    }

    private function changeMySqlColumnType(string $type): void
    {
        $driver = DB::connection()->getDriverName();
        if (in_array($driver, ['sqlite', 'pgsql'], true)) {
            // SQLite and PostgreSQL TEXT columns already support long-form content.
            return;
        }

        if ($driver !== 'mysql') {
            throw new RuntimeException("No se puede cambiar el tipo de la reseña en el driver [{$driver}].");
        }

        DB::statement(
            "ALTER TABLE `rh_resena_historica` MODIFY `resena_historica` {$type} "
            .'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL'
        );
    }
};
