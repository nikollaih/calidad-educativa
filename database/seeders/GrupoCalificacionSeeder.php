<?php

namespace Database\Seeders;

use App\Models\GrupoCalificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoCalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $grupoCalificaciones = [
            // Niveles principales
            [ 'nombre' => 'GESTIÓN DIRECTIVA',                   'indice' => '1', 'padre_id' => null],
            [ 'nombre' => 'GESTIÓN ACADÉMICA',                   'indice' => '2', 'padre_id' => null],
            [ 'nombre' => 'GESTIÓN ADMINISTRATIVA Y FINANCIERA', 'indice' => '3', 'padre_id' => null],
            [ 'nombre' => 'GESTIÓN DE LA COMUNIDAD',             'indice' => '4', 'padre_id' => null],
            // Subniveles de gestion directiva
            [ 'nombre' => 'Direccionamiento Estratégico',        'indice' => '1.1', 'padre_id' => 1],
            [ 'nombre' => 'Gestión Estratégica',                 'indice' => '1.2', 'padre_id' => 1],
            [ 'nombre' => 'Gobierno Escolar',                    'indice' => '1.3', 'padre_id' => 1],
            [ 'nombre' => 'Cultura Institucional',               'indice' => '1.4', 'padre_id' => 1],
            [ 'nombre' => 'Clima Escolar',                       'indice' => '1.5', 'padre_id' => 1],
            [ 'nombre' => 'Relaciones Con El Entorno',           'indice' => '1.6', 'padre_id' => 1],
            // Subniveles de gestion academica
            [ 'nombre' => 'Diseño Pedagógico',                   'indice' => '2.1', 'padre_id' => 2],
            [ 'nombre' => 'Prácticas Pedagógicas',               'indice' => '2.2', 'padre_id' => 2],
            [ 'nombre' => 'Gestón de Aula',                      'indice' => '2.3', 'padre_id' => 2],
            [ 'nombre' => 'Seguimiento Académico',               'indice' => '2.4', 'padre_id' => 2],
            // Subniveles de gestion administrativa
            [ 'nombre' => 'Apoyo a la gestión académica',                         'indice' => '3.1', 'padre_id' => 3],
            [ 'nombre' => 'Administración de la planta física y de los recursos', 'indice' => '3.2', 'padre_id' => 3],
            [ 'nombre' => 'Administración de los Servicios Complementarios',      'indice' => '3.3', 'padre_id' => 3],
            [ 'nombre' => 'Talento humano',                                       'indice' => '3.4', 'padre_id' => 3],
            [ 'nombre' => 'Apoyo financiero y contable',                          'indice' => '3.5', 'padre_id' => 3],
            // Subniveles de gestion de la comunidad
            [ 'nombre' => 'Accesibilidad',                   'indice' => '4.1', 'padre_id' => 4],
            [ 'nombre' => 'Proyección a la comunidad',       'indice' => '4.2', 'padre_id' => 4],
            [ 'nombre' => 'Participación y convivencia',     'indice' => '4.3', 'padre_id' => 4],
            [ 'nombre' => 'Prevención de riesgos',           'indice' => '4.4', 'padre_id' => 4],
        ];
            foreach ($grupoCalificaciones as $grupo) {
            GrupoCalificacion::firstOrCreate(
                $grupo, // Condición para buscar
                $grupo // Datos a insertar/actualizar
            );
        }
    }
}

