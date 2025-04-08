<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calificaciones = [
            // calificaciones de gestion directiva

            [ 
                'nombre' => 'Misión, visión y principios, en el marco de una institución integrada',
                'indice' => '1.1.1',
                'grupo_indice' => '1.1'
            ],
            [ 
                'nombre' => 'Metas institucionales',
                'indice' => '1.1.2',
                'grupo_indice' => '1.1'
            ],
            [ 
                'nombre' => 'Política de inclusión de personas de diferentes grupos poblacionales o diversidad cultural',
                'indice' => '1.1.4',
                'grupo_indice' => '1.1'
            ],
            [ 
                'nombre' => 'Liderazgo y trabajo en equipo',
                'indice' => '1.2.1',
                'grupo_indice' => '1.2'
            ],
            [ 
                'nombre' => 'Articulación de planes, proyectos y acciones',
                'indice' => '1.2.2',
                'grupo_indice' => '1.2'
            ],
            [ 
                'nombre' => 'Seguimiento y autoevaluación',
                'indice' => '1.2.5',
                'grupo_indice' => '1.2'
            ],
            [ 
                'nombre' => 'Consejo directivo',
                'indice' => '1.3.1',
                'grupo_indice' => '1.3'
            ],
            [ 
                'nombre' => 'Consejo académico',
                'indice' => '1.3.2',
                'grupo_indice' => '1.3'
            ],
            [ 
                'nombre' => 'Comité de convivencia',
                'indice' => '1.3.4',
                'grupo_indice' => '1.3'
            ],
            [ 
                'nombre' => 'Consejo estudiantil',
                'indice' => '1.3.5',
                'grupo_indice' => '1.3'
            ],
            [ 
                'nombre' => 'Personero estudiantil',
                'indice' => '1.3.6',
                'grupo_indice' => '1.3'
            ],
            [ 
                'nombre' => 'Asamblea de padres de familia',
                'indice' => '1.3.7',
                'grupo_indice' => '1.3'
            ],
            [ 
                'nombre' => 'Consejo de padres de familia',
                'indice' => '1.3.8',
                'grupo_indice' => '1.3'
            ],
            [ 
                'nombre' => 'Política de comunicación institucional',
                'indice' => '1.4.1',
                'grupo_indice' => '1.4'
            ],
            [ 
                'nombre' => 'Política de bienestar',
                'indice' => '1.4.3',
                'grupo_indice' => '1.4'
            ],
            [ 
                'nombre' => 'Apoyo a la investigación y divulgación de buenas prácticas',
                'indice' => '1.4.4',
                'grupo_indice' => '1.4'
            ],
            [ 
                'nombre' => 'Sentido de pertenencia y participación',
                'indice' => '1.5.1',
                'grupo_indice' => '1.5'
            ],
            [ 
                'nombre' => 'Ambiente físico',
                'indice' => '1.5.2',
                'grupo_indice' => '1.5'
            ],
            [ 
                'nombre' => 'Programa de inducción institucional',
                'indice' => '1.5.3',
                'grupo_indice' => '1.5'
            ],
            [ 
                'nombre' => 'Motivación hacia el aprendizaje',
                'indice' => '1.5.4',
                'grupo_indice' => '1.5'
            ],
            [ 
                'nombre' => 'Manual de convivencia',
                'indice' => '1.5.5',
                'grupo_indice' => '1.5'
            ],
            [ 
                'nombre' => 'Actividades extracurriculares',
                'indice' => '1.5.6',
                'grupo_indice' => '1.5'
            ],
            [ 
                'nombre' => 'Manejo de conflictos y casos díficiles',
                'indice' => '1.5.8',
                'grupo_indice' => '1.5'
            ],
            [ 
                'nombre' => 'Familias o acudientes',
                'indice' => '1.6.1',
                'grupo_indice' => '1.6'
            ],
            [ 
                'nombre' => 'Relaciones con los egresados',
                'indice' => '1.6.2',
                'grupo_indice' => '1.6'
            ],
            [ 
                'nombre' => 'Alianzas, acuerdos y proyectos con otras instituciones',
                'indice' => '1.6.3',
                'grupo_indice' => '1.6'
            ],
            [ 
                'nombre' => 'Alianzas con el sector productivo',
                'indice' => '1.6.4',
                'grupo_indice' => '1.6'
            ],

        ];
            foreach ($calificaciones as $calificacion) {
            Calificacion::firstOrCreate(
                $calificacion, // Condición para buscar
                $calificacion // Datos a insertar/actualizar
            );
        }
    }
}
