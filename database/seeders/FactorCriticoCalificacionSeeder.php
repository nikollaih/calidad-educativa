<?php

namespace Database\Seeders;

use App\Models\FactorCriticoCalificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorCriticoCalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $factoresCriticos = [
            [
                "indice_calificacion" => "3.2.3",
                "descripcion" => "La institución no cuenta con programas de seguridad integrales y actualizados que garanticen la protección de la comunidad educativa, ni realiza mantenimientos preventivos periódicos a los sistemas de seguridad instalados, lo que pone en riesgo la integridad física de estudiantes, docentes y personal administrativo."
            ],
            [
                "indice_calificacion" => "1.1.1",
                "descripcion" => "La institución no cuenta con una misión, visión ni principios claramente articulados que la identifiquen como un todo, y estos componentes no han sido apropiados de forma suficiente por la comunidad educativa."
            ],
            [
                "indice_calificacion" => "1.1.2",
                "descripcion" => "No todas las metas establecidas para la institución integrada e inclusiva responden a sus objetivos ni al direccionamiento estratégico; además, no son suficientemente conocidas ni puestas en práctica por toda la comunidad educativa."
            ],
            [
                "indice_calificacion" => "1.1.3",
                "descripcion" => "La Institución Educativa carece de una política efectiva para promover la inclusión de personas de diferentes grupos poblacionales o diversidad cultural, lo que limita la adaptación de metodologías, la adecuación de espacios, el apoyo a talentos y su valoración por los estamentos de la comunidad educativa. Asimismo, no se coordina adecuadamente con otros organismos para garantizar su atención integral."
            ],
            [
                "indice_calificacion" => "1.2.1",
                "descripcion" => "Los criterios básicos sobre el manejo del establecimiento educativo y la atención a la diversidad no fueron definidos de manera participativa suficiente, y no permiten consolidar el trabajo en equipo ni garantizan eficazmente la ejecución de los proyectos institucionales, pues no se han evaluado para verificar su eficacia."
            ],
            [
                "indice_calificacion" => "1.2.2",
                "descripcion" => "Los planes, proyectos y acciones no se enmarcan de manera coherente en principios de corresponsabilidad, participación y equidad, ni se articulan de forma efectiva al planteamiento estratégico de la institución integrada e inclusiva. Además, no son suficientemente conocidos por la comunidad educativa y no se evidencia un trabajo en equipo sólido para articular las acciones."
            ],
            [
                "indice_calificacion" => "1.2.3",
                "descripcion" => "La institución no implementa de forma integral un proceso de autoevaluación a partir de resultados de evaluaciones internas, externas y de desempeño, ni garantiza su aplicación en todas las sedes mediante instrumentos y procedimientos claros. Tampoco asegura la participación real de todos los estamentos de la comunidad educativa, ni evidencia resultados consistentes en el plan de mejoramiento institucional ni en la resignificación del P"
            ],
            [
                "indice_calificacion" => "1.3.1",
                "descripcion" => "El consejo directivo no cuenta con una agenda ni un cronograma de trabajo claramente implementados para orientar los procesos de planeación y seguimiento a las acciones institucionales, y no se reúne con la regularidad necesaria."
            ],
            [
                "indice_calificacion" => "1.3.2",
                "descripcion" => "El consejo académico no se reúne con la periodicidad requerida para garantizar la coherencia del componente pedagógico con las necesidades de la diversidad, ni asegura su implementación efectiva en todas las sedes, áreas y niveles, y no hace seguimiento suficiente."
            ],
            [
                "indice_calificacion" => "1.3.3",
                "descripcion" => "El comité de convivencia no se reúne con la frecuencia ni la eficacia necesarias y no es reconocido plenamente como la instancia encargada de analizar y plantear soluciones a los problemas de convivencia de la institución."
            ],
            [
                "indice_calificacion" => "1.3.4",
                "descripcion" => "El consejo estudiantil no se reúne de manera constante ni es reconocido de forma efectiva como la instancia de representación de los intereses de todos y todas los estudiantes."
            ],
            [
                "indice_calificacion" => "1.3.5",
                "descripcion" => "El personero elegido no desarrolla de forma consistente proyectos y programas a favor de los estudiantes, y su labor no es reconocida plenamente por los diferentes estamentos de la comunidad educativa."
            ],
            [
                "indice_calificacion" => "1.3.6",
                "descripcion" => "La asamblea de padres de familia no se reúne regularmente ni es reconocida adecuadamente por la comunidad educativa."
            ],
            [
                "indice_calificacion" => "1.3.7",
                "descripcion" => "El consejo de padres de familia no se reúne de forma periódica ni apoya de manera efectiva al rector o director en el marco del plan de mejoramiento; además, no realiza un seguimiento sistemático a los resultados obtenidos."
            ],
            [
                "indice_calificacion" => "1.4.1",
                "descripcion" => "La institución no cuenta con una política de comunicación institucional actualizada para informar y mantener al día a cada estamento de la comunidad educativa, y no evalúa su efectividad."
            ],
            [
                "indice_calificacion" => "1.4.2",
                "descripcion" => "La institución carece de un programa de bienestar que integre de manera efectiva un sistema de estímulos y reconocimiento de logros para docentes, estudiantes, padres de familia y personal administrativo, o no se cumple en su totalidad ni se aplica de forma coherente, sistemática y organizada."
            ],
            [
                "indice_calificacion" => "1.4.3",
                "descripcion" => "La institución no ha implementado de manera consistente el programa para apoyar la investigación e identificación de buenas prácticas pedagógicas, administrativas y culturales, ni garantiza el reconocimiento de la diversidad de la población ni el intercambio real de experiencias."
            ],
            [
                "indice_calificacion" => "1.5.1",
                "descripcion" => "Los estudiantes, docentes, padres de familia y administrativos no se identifican ni sienten un sentido de pertenencia suficiente hacia la institución, lo que se refleja en una débil aplicación de instrumentos valorativos y actitudinales, y en una escasa participación y representación en eventos internos y externos."
            ],
            [
                "indice_calificacion" => "1.5.2",
                "descripcion" => "La institución no cuenta con un programa estructurado de inducción y reinducción que adapte estrategias a las condiciones personales, sociales y culturales de sus integrantes, ni asegura su socialización efectiva al inicio del año escolar."
            ],
            [
                "indice_calificacion" => "1.5.3",
                "descripcion" => "El manual de convivencia no se emplea de manera activa como instrumento para orientar valores, principios, normas y procedimientos, ni garantiza la convivencia armónica ni el respeto por la diversidad."
            ],
            [
                "indice_calificacion" => "1.5.4",
                "descripcion" => "La institución no cuenta con un programa institucional sólido de actividades extracurriculares orientado al fortalecimiento de capacidades artísticas, deportivas, sociales, emocionales y éticas de los estudiantes."
            ],
            [
                "indice_calificacion" => "1.5.5",
                "descripcion" => "La comunidad educativa no reconoce de manera suficiente al comité de convivencia como instancia para identificar y prevenir conflictos y casos difíciles, ni se implementan de forma efectiva mecanismos internos y externos para prevenir riesgos y manejar situaciones complejas con participación de toda la comunidad."
            ],
            [
                "indice_calificacion" => "1.6.1",
                "descripcion" => "No existe un intercambio fluido de información con las familias o acudientes, lo que afecta la coherencia con la política institucional, dificulta la atención oportuna a situaciones y debilita la corresponsabilidad educativa."
            ],
            [
                "indice_calificacion" => "1.6.2",
                "descripcion" => "A través del programa institucional de egresados no se realiza un seguimiento regular ni se utilizan indicadores suficientes para orientar acciones pedagógicas; además, no se promueve efectivamente su participación u organización, ni se mantiene actualizada la base de datos de información sobre sus estudios o vinculación laboral."
            ],
            [
                "indice_calificacion" => "1.6.3",
                "descripcion" => "No existe un intercambio fluido de información con las familias o acudientes, afectando la coherencia con la política institucional y dificultando la atención oportuna de situaciones, lo cual debilita la corresponsabilidad educativa."
            ],
            [
                "indice_calificacion" => "1.6.4",
                "descripcion" => "Las alianzas con el sector productivo carecen de objetivos y metodologías claras orientadas a fortalecer competencias de los estudiantes, y no se realizan procesos periódicos de seguimiento y evaluación de forma suficiente."
            ],
            [
                "indice_calificacion" => "2.1.1",
                "descripcion" => "El plan de estudios no está estructurado de forma coherente con el PEI ni con el contexto institucional, ni promueve efectivamente la inclusión o el desarrollo de competencias para la vida, ni se aplica de forma articulada en todas las sedes y niveles."
            ],
            [
                "indice_calificacion" => "2.1.2",
                "descripcion" => "El enfoque metodológico institucional no se orienta de manera adecuada al aprendizaje activo, colaborativo, significativo e inclusivo, ni se aplica de forma articulada en los distintos niveles y sedes."
            ],
            [
                "indice_calificacion" => "2.1.3",
                "descripcion" => "La institución no ha definido claramente una estrategia pedagógica coherente con el PEI que propicie procesos de enseñanza centrados en competencias y atención a la diversidad, ni garantiza su aplicación articulada en sedes, niveles y grados."
            ],
            [
                "indice_calificacion" => "2.1.4",
                "descripcion" => "La ruta de seguimiento y control a las horas efectivas de clase no forma parte de un sistema sólido de mejoramiento institucional, ni se implementa de forma efectiva en todas las sedes ni es aplicada consistentemente por los docentes."
            ],
            [
                "indice_calificacion" => "2.1.5",
                "descripcion" => "El SIEE no se aplica de forma coherente ni sistemática, lo que limita la orientación de los procesos de evaluación formativa, la promoción escolar y el mejoramiento institucional conforme a la normatividad vigente."
            ],
            [
                "indice_calificacion" => "2.2.1",
                "descripcion" => "La institución no implementa estrategias claras ni objetivas sobre la funcionalidad pedagógica de las tareas escolares para fortalecer aprendizajes, ni asegura que sean aplicadas por todos los docentes ni que estén claramente definidas en el SIEE."
            ],
            [
                "indice_calificacion" => "2.2.2",
                "descripcion" => "La institución no cuenta con una estrategia sólida para el uso apropiado de los tiempos de aprendizaje, ni garantiza su articulación con la planeación pedagógica ni su implementación flexible de acuerdo con las características de los estudiantes. Además, hay escasas oportunidades para complementarla con actividades extracurriculares o de refuerzo."
            ],
            [
                "indice_calificacion" => "2.2.3",
                "descripcion" => "Las prácticas pedagógicas de los docentes no se fundamentan consistentemente en opciones didácticas comunes y diferenciadas adecuadas para cada grupo poblacional, ni están alineadas con el plan de estudios y el contexto, ni son suficientemente conocidas, compartidas o valoradas por la comunidad educativa."
            ],
            [
                "indice_calificacion" => "2.3.1",
                "descripcion" => "Los ambientes de aprendizaje no se diseñan ni organizan adecuadamente para favorecer el proceso de enseñanza-aprendizaje, ni promueven de forma suficiente la participación, el trabajo colaborativo o la atención a la diversidad, limitando la comunicación, el vínculo afectivo y la valoración de las diferencias entre los estudiantes."
            ],
            [
                "indice_calificacion" => "2.3.2",
                "descripcion" => "La institución no desarrolla ni implementa estrategias efectivas para fomentar el interés, la curiosidad y el compromiso de los estudiantes con su aprendizaje."
            ],
            [
                "indice_calificacion" => "2.3.3",
                "descripcion" => "Los planes de aula, que desarrollan el plan de estudios, no presentan una secuencia didáctica clara y articulada con la estrategia pedagógica y el enfoque metodológico institucional, ni garantizan la accesibilidad para todo el estudiantado, lo que limita la reducción de barreras al aprendizaje."
            ],
            [
                "indice_calificacion" => "2.3.4",
                "descripcion" => "La evaluación en el aula no se desarrolla con criterios claros ni acordes con el SIEE, ni incluye la retroalimentación como herramienta efectiva para el mejoramiento del aprendizaje."
            ],
            [
                "indice_calificacion" => "2.4.1",
                "descripcion" => "La institución educativa no cuenta con un proceso sistemático de seguimiento y retroalimentación a los desempeños de los estudiantes, ni asegura su aplicación oportuna en todos los grados, ni garantiza que sea conocido por estudiantes y padres de familia."
            ],
            [
                "indice_calificacion" => "2.4.2",
                "descripcion" => "Las conclusiones de los análisis de resultados en evaluaciones externas no se utilizan adecuadamente como insumo para construir planes de mejoramiento por área o grado, ni se aplican de forma consistente por todos los docentes."
            ],
            [
                "indice_calificacion" => "2.4.3",
                "descripcion" => "La estrategia institucional de control, análisis y tratamiento del ausentismo estudiantil no contempla de manera efectiva la participación activa de padres, docentes y estudiantes."
            ],
            [
                "indice_calificacion" => "2.4.4",
                "descripcion" => "La institución no cuenta con estrategias organizadas de apoyo pedagógico articuladas efectivamente al PEI, al plan de estudios y a las necesidades reales de los estudiantes."
            ],
            [
                "indice_calificacion" => "3.1.1",
                "descripcion" => "El proceso de matrícula no se ejecuta de forma articulada, oportuna ni transparente, lo que limita el acceso y permanencia de todos los estudiantes en igualdad de condiciones."
            ],
            [
                "indice_calificacion" => "3.1.2",
                "descripcion" => "La institución no dispone de un sistema de información académica organizado, confiable y actualizado, lo que dificulta el registro, archivo y consulta de calificaciones, la generación de boletines y la disponibilidad de información para docentes, estudiantes y familias."
            ],
            [
                "indice_calificacion" => "3.2.1",
                "descripcion" => "La institución no implementa un plan organizado de mantenimiento preventivo, adecuación y embellecimiento de la planta física, lo que compromete el uso eficiente de los espacios y no previene el hacinamiento, ni asegura criterios técnicos ni la participación de la comunidad educativa."
            ],
            [
                "indice_calificacion" => "3.2.2",
                "descripcion" => "La institución no cuenta con un plan institucional claro para la adquisición, dotación y suministro de recursos para el aprendizaje, ni contempla criterios de calidad, pertinencia y equidad, ni incluye procedimientos de mantenimiento preventivo o uso responsable de los recursos educativos."
            ],
            [
                "indice_calificacion" => "3.3.1",
                "descripcion" => "La institución no gestiona ni articula eficientemente estrategias de acceso y permanencia, lo que afecta la equidad, la permanencia y las condiciones adecuadas para el aprendizaje."
            ],
            [
                "indice_calificacion" => "3.4.1",
                "descripcion" => "La asignación académica y de funciones no se realiza de forma técnica ni transparente, y no considera adecuadamente perfiles, competencias ni necesidades institucionales."
            ],
            [
                "indice_calificacion" => "3.4.2",
                "descripcion" => "La institución no implementa un programa institucional de formación y actualización docente y administrativa coherente con el PEI ni con las prioridades del contexto."
            ],
            [
                "indice_calificacion" => "3.4.3",
                "descripcion" => "El personal vinculado no demuestra un compromiso suficiente con los valores y metas institucionales, ni participa activamente en los procesos de mejoramiento institucional."
            ],
            [
                "indice_calificacion" => "3.4.4",
                "descripcion" => "La evaluación del desempeño no se aplica de forma técnica ni participativa, ni está alineada con la Guía 31 del MEN ni articulada al plan de mejoramiento institucional, limitando la identificación de necesidades de formación y el fortalecimiento de la calidad de la gestión educativa."
            ],
            [
                "indice_calificacion" => "3.4.5",
                "descripcion" => "La institución no dispone de estrategias claras para la mediación y solución de conflictos entre el personal, ni se resuelven mediante diálogo y negociación permanente, lo que debilita el ambiente de respeto, cooperación y clima laboral."
            ],
            [
                "indice_calificacion" => "3.5.1",
                "descripcion" => "El presupuesto del FSE no se formula, ejecuta ni monitorea de manera técnica ni participativa, ni se orienta efectivamente a los objetivos institucionales."
            ],
            [
                "indice_calificacion" => "3.5.2",
                "descripcion" => "No existen procesos claros para el recaudo de ingresos ni para la realización de gastos, estos no son conocidos por la comunidad educativa, ni funcionan de forma coherente con la planeación financiera de la institución. La contabilidad no se lleva actualizada ni cumple todos los requisitos normativos."
            ],
            [
                "indice_calificacion" => "3.5.3",
                "descripcion" => "La institución no cuenta con un proceso de contratación estructurado, ajustado a su manual institucional ni a los requerimientos de ley, ni asegura una planeación, selección y ejecución de contratos con pertinencia, transparencia y eficiencia."
            ],
            [
                "indice_calificacion" => "3.5.4",
                "descripcion" => "La institución no desarrolla mecanismos de control fiscal eficaces ni los articula al proceso de planeación, ejecución y evaluación institucional, ni los integra de forma efectiva al control interno para la toma de decisiones y seguimiento al manejo de recursos."
            ],
            [
                "indice_calificacion" => "4.1.1",
                "descripcion" => "La institución no trabaja articuladamente para diseñar ni aplicar estrategias pedagógicas pertinentes que integren y atiendan a personas pertenecientes a grupos étnicos o en situación de vulnerabilidad. Estas estrategias no se socializan ni se dan a conocer de forma suficiente a la comunidad educativa."
            ],
            [
                "indice_calificacion" => "4.1.2",
                "descripcion" => "La institución no cuenta con mecanismos efectivos para identificar, analizar y atender de forma sistemática las necesidades, expectativas e intereses de los estudiantes, ni los integra de manera coherente en los procesos educativos y de gestión, ni los comunica oportunamente a la comunidad educativa."
            ],
            [
                "indice_calificacion" => "4.1.3",
                "descripcion" => "La institución no manifiesta de forma programática ni consistente su interés en la proyección personal y el futuro de los estudiantes, ni asegura que este programa sea reconocido, apoyado o enriquecido por toda la comunidad educativa."
            ],
            [
                "indice_calificacion" => "4.2.1",
                "descripcion" => "La escuela de padres no desarrolla actividades formativas articuladas al PEI ni a las necesidades reales de las familias, ni logra una participación representativa."
            ],
            [
                "indice_calificacion" => "4.2.2",
                "descripcion" => "La institución no desarrolla una oferta organizada de servicios para la comunidad, ni garantiza su coherencia con el PEI ni su pertinencia frente a las necesidades del entorno."
            ],
            [
                "indice_calificacion" => "4.2.3",
                "descripcion" => "El servicio social estudiantil no se desarrolla como una experiencia significativa, ni promueve adecuadamente la participación, la ciudadanía y la proyección social de los estudiantes, ni contribuye de forma efectiva a solucionar necesidades de la comunidad."
            ],
            [
                "indice_calificacion" => "4.3.1",
                "descripcion" => "La institución no promueve activamente la participación de los estudiantes en procesos decisorios, pedagógicos o de convivencia."
            ],
            [
                "indice_calificacion" => "4.4.1",
                "descripcion" => "La institución no cuenta con un plan integral de prevención de riesgos físicos socializado ni puesto en práctica por toda la comunidad educativa."
            ],
            [
                "indice_calificacion" => "4.4.2",
                "descripcion" => "La institución, sin el apoyo suficiente de entidades externas, no implementa programas efectivos para sensibilizar a estudiantes y comunidad sobre riesgos ni para fortalecer la cultura de autocuidado y prevención, ni realiza seguimiento a los factores de riesgo detectados con participación activa."
            ]
        ];
        foreach ($factoresCriticos as $factor) {
            FactorCriticoCalificacion::updateOrCreate(
                [
                    'indice_calificacion' => $factor['indice_calificacion']
                ],
                $factor
            );
        }
    }
}
