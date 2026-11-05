<?php

namespace Database\Seeders;

use App\Models\GrupoCalificacion;
use App\Models\Calificacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class GrupoCalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = Guia34Catalogo::cargar();

        // Se conservan literalmente los cuatro niveles principales actuales.
        $nivelesPrincipales = [
            '1' => 'GESTIÓN DIRECTIVA',
            '2' => 'GESTIÓN ACADÉMICA',
            '3' => 'GESTIÓN ADMINISTRATIVA Y FINANCIERA',
            '4' => 'GESTIÓN DE LA COMUNIDAD',
        ];

        if (app()->environment('production')) {
            throw new RuntimeException('El reemplazo de la Guía 34 no debe ejecutarse en producción.');
        }

        if (DB::table('autoevaluacions')->exists() || DB::table('pmis')->exists()) {
            throw new RuntimeException(
                'Antes de reemplazar el catálogo Guía 34, ejecute php artisan calidad:limpiar-calificaciones en un entorno local. No ejecute esa limpieza en producción.'
            );
        }

        DB::transaction(function () use ($catalogo, $nivelesPrincipales): void {
            // Limpiar plantillas históricas, desde sus dependientes hacia los padres.
            DB::table('pmi_actividads')->delete();
            DB::table('pmi_metas')->delete();
            DB::table('pmi_objetivos')->delete();
            Calificacion::query()->delete();
            GrupoCalificacion::query()->whereNotNull('padre_id')->delete();
            GrupoCalificacion::query()
                ->whereNull('padre_id')
                ->whereNotIn('indice', array_keys($nivelesPrincipales))
                ->delete();

            foreach ($nivelesPrincipales as $indice => $nombre) {
                GrupoCalificacion::updateOrCreate(
                    ['indice' => $indice, 'padre_id' => null],
                    ['nombre' => $nombre]
                );
            }

            $idsPrincipales = GrupoCalificacion::query()
                ->whereNull('padre_id')
                ->whereIn('indice', array_keys($nivelesPrincipales))
                ->pluck('id', 'indice');

            foreach ($catalogo['procesos'] as $indice => $proceso) {
                $padreId = $idsPrincipales->get($proceso['padre_indice']);

                if ($padreId === null) {
                    throw new \RuntimeException("No existe el nivel principal {$proceso['padre_indice']} para el proceso {$indice}.");
                }

                GrupoCalificacion::updateOrCreate(
                    ['indice' => $indice, 'padre_id' => $padreId],
                    ['nombre' => $proceso['nombre']]
                );
            }
        });
    }
}
