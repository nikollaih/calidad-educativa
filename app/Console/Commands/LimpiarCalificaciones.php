<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LimpiarCalificaciones extends Command
{
    protected $signature = 'calidad:limpiar-calificaciones
                            {--dry-run : Muestra los registros afectados sin eliminarlos}
                            {--force : Ejecuta sin solicitar confirmación}';

    protected $description = 'NO EJECUTAR EN PRODUCCION. Elimina grupos, calificaciones, autoevaluaciones y sus datos PMI asociados.';

    /**
     * The tables are deleted from dependents to parents because several foreign
     * keys in the historical schema do not cascade on delete.
     *
     * @var array<int, string>
     */
    private const DELETE_ORDER = [
        'nota_autoevaluacions',
        'pmi_actividad_avance_files',
        'pmi_actividad_avances',
        'pmi_comentario_factors',
        'pmi_actividad_vinculadas',
        'pmi_indicador_vinculados',
        'pmi_meta_vinculadas',
        'pmi_objetivo_vinculados',
        // Estructura PMI anterior: estas relaciones usan SET NULL o no tienen cascade.
        'pmi_actividads',
        'pmi_metas',
        'pmi_objetivos',
        'pmis',
        'factor_criticos',
        'autoevaluacions',
        'factor_critico_calificacions',
        'nota_calificacions',
        'calificacions',
        'grupo_calificacions',
    ];

    /** @var array<int, string> */
    private const REQUIRED_TABLES = [
        'grupo_calificacions',
        'calificacions',
        'nota_calificacions',
        'autoevaluacions',
        'nota_autoevaluacions',
        'pmis',
        'factor_criticos',
        'factor_critico_calificacions',
    ];

    public function handle(): int
    {
        $this->newLine();
        $this->error('ADVERTENCIA: NO EJECUTAR EN PRODUCCION. Este comando elimina datos irreversiblemente.');

        if (app()->environment('production')) {
            $this->error('Ejecución bloqueada porque APP_ENV está configurado como production.');

            return self::FAILURE;
        }

        $missingTables = array_values(array_filter(
            self::REQUIRED_TABLES,
            fn (string $table): bool => ! Schema::hasTable($table)
        ));

        if ($missingTables !== []) {
            $this->error('No se ejecutó el borrado: faltan tablas requeridas: '.implode(', ', $missingTables));

            return self::FAILURE;
        }

        $counts = [];
        foreach (self::DELETE_ORDER as $table) {
            if (Schema::hasTable($table)) {
                $counts[$table] = DB::table($table)->count();
            }
        }

        $this->table(
            ['Tabla', 'Registros actuales'],
            collect($counts)->map(fn (int $count, string $table): array => [$table, $count])->values()->all()
        );

        $total = array_sum($counts);
        $this->warn("Total estimado en las tablas contempladas: {$total} registros.");

        if ($this->option('dry-run')) {
            $this->info('Simulación completada. No se eliminó ningún registro.');

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm(
            '¿Confirma borrar estos datos de forma permanente? Esta acción no se puede deshacer.',
            false
        )) {
            $this->info('Operación cancelada. No se eliminó ningún registro.');

            return self::SUCCESS;
        }

        try {
            $deleted = DB::transaction(function (): array {
                $results = [];

                foreach (self::DELETE_ORDER as $table) {
                    if (Schema::hasTable($table)) {
                        $results[$table] = DB::table($table)->delete();
                    }
                }

                return $results;
            });
        } catch (\Throwable $exception) {
            $this->error('El borrado falló y la transacción fue revertida: '.$exception->getMessage());

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Borrado completado. Registros eliminados directamente por tabla:');
        $this->table(
            ['Tabla', 'Registros eliminados'],
            collect($deleted)->map(fn (int $count, string $table): array => [$table, $count])->values()->all()
        );

        return self::SUCCESS;
    }
}
