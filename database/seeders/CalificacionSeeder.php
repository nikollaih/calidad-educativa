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
                'indice' => '1.1.3',
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
                'indice' => '1.2.3',
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
                'indice' => '1.3.3',
                'grupo_indice' => '1.3'
            ],
            [
                'nombre' => 'Consejo estudiantil',
                'indice' => '1.3.4',
                'grupo_indice' => '1.3'
            ],
            [
                'nombre' => 'Personero estudiantil',
                'indice' => '1.3.5',
                'grupo_indice' => '1.3'
            ],
            [
                'nombre' => 'Asamblea de padres de familia',
                'indice' => '1.3.6',
                'grupo_indice' => '1.3'
            ],
            [
                'nombre' => 'Consejo de padres de familia',
                'indice' => '1.3.7',
                'grupo_indice' => '1.3'
            ],
            [
                'nombre' => 'Política de comunicación institucional',
                'indice' => '1.4.1',
                'grupo_indice' => '1.4'
            ],
            [
                'nombre' => 'Política de bienestar',
                'indice' => '1.4.2',
                'grupo_indice' => '1.4'
            ],
            [
                'nombre' => 'Apoyo a la investigación y divulgación de buenas prácticas',
                'indice' => '1.4.3',
                'grupo_indice' => '1.4'
            ],
            [
                'nombre' => 'Sentido de pertenencia y participación de la comunidad educativa',
                'indice' => '1.5.1',
                'grupo_indice' => '1.5'
            ],
            [
                'nombre' => 'Programa de inducción institucional',
                'indice' => '1.5.2',
                'grupo_indice' => '1.5'
            ],
            [
                'nombre' => 'Manual de convivencia',
                'indice' => '1.5.3',
                'grupo_indice' => '1.5'
            ],
            [
                'nombre' => 'Actividades extracurriculares',
                'indice' => '1.5.4',
                'grupo_indice' => '1.5'
            ],
            [
                'nombre' => 'Manejo de conflictos y casos díficiles.',
                'indice' => '1.5.5',
                'grupo_indice' => '1.5'
            ],
            [
                'nombre' => 'Familias o acudientes',
                'indice' => '1.6.1',
                'grupo_indice' => '1.6'
            ],
            [
                'nombre' => 'Egresados',
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
            // Gestion academica
            [
                'nombre' => 'Plan de estudios',
                'indice' => '2.1.1',
                'grupo_indice' => '2.1'
            ],
            [
                'nombre' => 'Enfoque metodológico',
                'indice' => '2.1.2',
                'grupo_indice' => '2.1'
            ],
            [
                'nombre' => 'Estrategia pedagógica',
                'indice' => '2.1.3',
                'grupo_indice' => '2.1'
            ],
            [
                'nombre' => 'Jornada escolar',
                'indice' => '2.1.4',
                'grupo_indice' => '2.1'
            ],
            [
                'nombre' => 'Sistema Institucional de Evaluación de los Estudiantes (SIEE)',
                'indice' => '2.1.5',
                'grupo_indice' => '2.1'
            ],
            [
                'nombre' => 'Estrategias para las tareas escolares',
                'indice' => '2.2.1',
                'grupo_indice' => '2.2'
            ],

            [
                'nombre' => 'Uso de los tiempos para el aprendizaje',
                'indice' => '2.2.2',
                'grupo_indice' => '2.2'
            ],
            [
                'nombre' => 'Opciones didácticas para las áreas, asignaturas y proyectos transversales',
                'indice' => '2.2.3',
                'grupo_indice' => '2.2'
            ],

            [
                'nombre' => 'Ambientes de aprendizaje',
                'indice' => '2.3.1',
                'grupo_indice' => '2.3'
            ],
            [
                'nombre' => 'Motivación hacia el aprendizaje',
                'indice' => '2.3.2',
                'grupo_indice' => '2.3'
            ],
            [
                'nombre' => 'Plan de aula',
                'indice' => '2.3.3',
                'grupo_indice' => '2.3'
            ],
            [
                'nombre' => 'Evaluación en el aula',
                'indice' => '2.3.4',
                'grupo_indice' => '2.3'
            ],

            [
                'nombre' => 'Seguimiento a los desempeños de los estudiantes',
                'indice' => '2.4.1',
                'grupo_indice' => '2.4'
            ],
            [
                'nombre' => 'Uso pedagógico de las evaluaciones externas',
                'indice' => '2.4.2',
                'grupo_indice' => '2.4'
            ],
            [
                'nombre' => 'Seguimiento a la asistencia',
                'indice' => '2.4.3',
                'grupo_indice' => '2.4'
            ],
            [
                'nombre' => 'Apoyo pedagógico para estudiantes con dificultades de aprendizaje',
                'indice' => '2.4.4',
                'grupo_indice' => '2.4'
            ],
            // gestion administrativa
            [
                'nombre' => 'Proceso de matrícula',
                'indice' => '3.1.1',
                'grupo_indice' => '3.1'
            ],
            [
                'nombre' => 'Sistema de información académica',
                'indice' => '3.1.2',
                'grupo_indice' => '3.1'
            ],

            [
                'nombre' => 'Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa',
                'indice' => '3.2.1',
                'grupo_indice' => '3.2'
            ],
            [
                'nombre' => 'Dotación, mantenimiento y uso de recursos para el aprendizaje',
                'indice' => '3.2.2',
                'grupo_indice' => '3.2'
            ],
            [
                'nombre' => 'Programas de seguridad',
                'indice' => '3.2.3',
                'grupo_indice' => '3.2'
            ],
            [
                'nombre' => 'Estrategias de acceso y permanencia (PAE, transporte escolar y otros).',
                'indice' => '3.3.1',
                'grupo_indice' => '3.3'
            ],


            [
                'nombre' => 'Perfiles, asignación académica y de funciones',
                'indice' => '3.4.1',
                'grupo_indice' => '3.4'
            ],
            [
                'nombre' => 'Programa de formación y capacitación institucional',
                'indice' => '3.4.2',
                'grupo_indice' => '3.4'
            ],
            [
                'nombre' => 'Pertenencia del personal vinculado',
                'indice' => '3.4.3',
                'grupo_indice' => '3.4'
            ],
            [
                'nombre' => 'Evaluación del desempeño de directivos, docentes  y administrativos',
                'indice' => '3.4.4',
                'grupo_indice' => '3.4'
            ],
            [
                'nombre' => 'Convivencia y manejo de conflictos',
                'indice' => '3.4.5',
                'grupo_indice' => '3.4'
            ],

            [
                'nombre' => 'Presupuesto anual del Fondo de Servicios Educativos (FSE)',
                'indice' => '3.5.1',
                'grupo_indice' => '3.5'
            ],
            [
                'nombre' => 'Contabilidad',
                'indice' => '3.5.2',
                'grupo_indice' => '3.5'
            ],
            [
                'nombre' => 'Contratación',
                'indice' => '3.5.3',
                'grupo_indice' => '3.5'
            ],
            [
                'nombre' => 'Control fiscal',
                'indice' => '3.5.4',
                'grupo_indice' => '3.5'
            ],

            // Gestion de la comunidad


            [
                'nombre' => 'Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación',
                'indice' => '4.1.1',
                'grupo_indice' => '4.1'
            ],
            [
                'nombre' => 'Necesidades y expectativas de los estudiantes',
                'indice' => '4.1.2',
                'grupo_indice' => '4.1'
            ],
            [
                'nombre' => 'Proyectos de vida',
                'indice' => '4.1.3',
                'grupo_indice' => '4.1'
            ],


            [
                'nombre' => 'Escuela de padres',
                'indice' => '4.2.1',
                'grupo_indice' => '4.2'
            ],
            [
                'nombre' => 'Oferta de servicios a la comunidad',
                'indice' => '4.2.2',
                'grupo_indice' => '4.2'
            ],
            [
                'nombre' => 'Programa de servicio social institucional',
                'indice' => '4.2.3',
                'grupo_indice' => '4.2'
            ],

            [
                'nombre' => 'Participación de los estudiantes',
                'indice' => '4.3.1',
                'grupo_indice' => '4.3'
            ],
            [
                'nombre' => 'Prevención de riesgos físicos',
                'indice' => '4.4.1',
                'grupo_indice' => '4.4'
            ],
            [
                'nombre' => 'Prevención de riesgos psicosociales',
                'indice' => '4.4.2',
                'grupo_indice' => '4.4'
            ],


        ];
            foreach ($calificaciones as $calificacion) {
            Calificacion::UpdateOrCreate(
               // Condición para buscar
                [
                    'indice' => $calificacion['indice'],
                    'grupo_indice' => $calificacion['grupo_indice'],
                ],
                // Datos a insertar/actualizar
                [
                    'nombre' => $calificacion['nombre'],
                ]
            );
        }
    }
}
