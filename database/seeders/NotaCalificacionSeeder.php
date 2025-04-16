<?php

namespace Database\Seeders;

use App\Models\NotaCalificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotaCalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notasCalificaciones = [
            [
                'descripcion' => 'Los estudiantes se identifican con la institución y sienten orgullo de pertenecer a ella. Además, participan activamente en actividades internas y externas, en su representación. Se resalta el valor de la diversidad y la importancia del ejercicio de los derechos de todos y todas, lo cual permite mayor participación e integración entre todos sus estamentos.',
                'valor' => 3,
                'indice_calificacion' => '1.5.1'
            ],
            [
                'descripcion' => 'Los informes financieros presentados
por la institución a
las autoridades competentes
no siempre se hacen de manera
oportuna y no son conocidos
por la comunidad educativa.',
                'valor' => 1,
                'indice_calificacion' => '3.5.4'
            ],
            [
                'descripcion' => 'Se cuenta con un plan de estudios para toda la institución que, además de responder a las políticas trazadas en el PEI, los lineamientos y
los estándares básicos de competencias, fundamenta los planes de aula de los docentes de todas las áreas, grados y sedes. Otorga especial importancia a la enseñanza y el aprendizaje de contenidos actitudinales, de valores y normas relacionados con las diferencias individuales, raciales, culturales, familiares, que le permitan valorar, aceptar y comprender la diversidad y la interdependencia humana.',
                'valor' => 3,
                'indice_calificacion' => '2.1.1'
            ],
            [
                'descripcion' => 'La institución cuenta con un
personero elegido democráticamente
que representa a todas y todos los estudiantes de todas las sedes, pero no es tenido en cuenta en las decisiones.',
                'valor' => 2,
                'indice_calificacion' => '1.3.6'
            ],
            [
                'descripcion' => 'La formación y la capacitación
son asumidas como un asunto
de interés particular de cada
docente. La institución acepta
procesos de formación sin evaluar
su pertinencia con respecto
al PEI o sus necesidades.',
                'valor' => 1,
                'indice_calificacion' => '3.4.3'
            ],
            [
                'descripcion' => 'El servicio social obligatorio de
los estudiantes es un requisito,
pero se encuentra desarticulado
de la institución y su entorno.',
                'valor' => 1,
                'indice_calificacion' => '4.2.4'
            ],
            [
                'descripcion' => 'La asamblea de padres de familia se reúne periódicamente y cuenta con la participación activa de sus miembros. Además, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo.',
                'valor' => 4,
                'indice_calificacion' => '1.3.7'
            ],
            [
                'descripcion' => 'La institución ha definido parcialmente
un enfoque metodológico que hace explícitos los métodos de enseñanza por áreas o grados.',
                'valor' => 1,
                'indice_calificacion' => '2.1.6'
            ],
            [
                'descripcion' => 'Los estudiantes se sienten parte de la institución, pero se
identifican principalmente con
algunos elementos tales como
las instalaciones, el escudo, el
uniforme, o el himno.',
                'valor' => 1,
                'indice_calificacion' => '1.5.1'
            ],
            [
                'descripcion' => 'El consejo académico se reúne periódicamente
para garantizar que el proyecto pedagógico
sea coherente con las necesidades de la diversidad y se implemente en todas las sedes, áreas y niveles. Sin embargo, no hace seguimiento suficiente al mismo.',
                'valor' => 3,
                'indice_calificacion' => '1.3.2'
            ],
            [
                'descripcion' => 'La institución establece comunicaciones con las familias o acudientes en función de las demandas y necesidades presentadas.
De manera general, cada sede posee sus propios
canales de comunicación.',
                'valor' => 1,
                'indice_calificacion' => '1.6.1'
            ],
            [
                'descripcion' => 'La institución ofrece a los padres
de familia algunos talleres y charlas sobre diversos temas,
aunque sin una programación
clara.',
                'valor' => 1,
                'indice_calificacion' => '4.2.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente el impacto de sus alianzas con el sector productivo en el ámbito del fortalecimiento de las competencias de los estudiantes. Los resultados de estas evaluaciones son la base para la realización de acciones de mejoramiento institucional.',
                'valor' => 4,
                'indice_calificacion' => '1.6.4'
            ],
            [
                'descripcion' => 'La institución cuenta con una
política para identificar y divulgar
las buenas prácticas pedagógicas, administrativas y culturales.',
                'valor' => 2,
                'indice_calificacion' => '1.4.4'
            ],
            [
                'descripcion' => 'El servicio social estudiantil tiene proyectos que responden a las necesidades de la comunidad
y éstos, a su vez, son pertinentes para la actividad institucional.',
                'valor' => 2,
                'indice_calificacion' => '4.2.4'
            ],
            [
                'descripcion' => 'Las conclusiones de los análisis de los resultados de los estudiantes en las evaluaciones externas son fuente de información para la construcción de los planes de mejoramiento por área y por grado y es aplicado por todos los docentes.',
                'valor' => 3,
                'indice_calificacion' => '2.4.2'
            ],
            [
                'descripcion' => 'La institución ha establecido
alianzas con el sector productivo.
Éstas tienen muy claros los objetivos, metodologías de trabajo y sistemas de seguimiento generados por parte de las instancias involucradas.',
                'valor' => 2,
                'indice_calificacion' => '1.6.4'
            ],
            [
                'descripcion' => 'La institución presenta los informes financieros
a las autoridades competentes de manera
apropiada y oportuna. Éstos son parte del
proceso de control interno y sirven para tomar
decisiones y realizar seguimiento al manejo
de los recursos.',
                'valor' => 3,
                'indice_calificacion' => '3.5.4'
            ],
            [
                'descripcion' => 'La institución cuenta con programas organizados con el apoyo de otras entidades que buscan favorecer los aprendizajes de los estudiantes y de la comunidad sobre los riesgos a que están expuestos y crear una cultura del autocuidado y de la prevención. Los estudiantes y la comunidad se vinculan a estos programas. Existen mecanismos de seguimiento a los factores de riesgo identificados como significativos para la comunidad y los estudiantes.',
                'valor' => 3,
                'indice_calificacion' => '4.4.2'
            ],
            [
                'descripcion' => 'Hay conocimiento sobre las
fuentes potenciales de los conflictos,
pero la institución no
cuenta con estrategias para
abordarlos eficazmente; en algunas
oportunidades se hacen
reuniones pero no hay avances
en la solución de los mismos.',
                'valor' => 1,
                'indice_calificacion' => '3.4.9'
            ],
            [
                'descripcion' => 'La institución educativa cuenta con un proceso de seguimiento y retroalimentación sistemático a los desempeños de los estudiantes y se aplica de manera oportuna en todos los grados. Además, es conocido por los estudiantes y padres de familia.',
                'valor' => 3,
                'indice_calificacion' => '2.4.1'
            ],
            [
                'descripcion' => 'Los mecanismos para el seguimiento a las horas efectivas de clase recibidas por los estudiantes
hacen parte de un sistema de mejoramiento
institucional que se implementa en todas las
sedes y es aplicado por los docentes.',
                'valor' => 3,
                'indice_calificacion' => '2.1.4'
            ],
            [
                'descripcion' => 'La institución tiene un programa de formación
que responde a problemas identificados
y demandas específicas; existen criterios claros
para valorar la oferta externa y se cuenta
con destinación de recursos para adelantar
procesos internos de capacitación.',
                'valor' => 3,
                'indice_calificacion' => '3.4.3'
            ],
            [
                'descripcion' => 'La institución dispone de estrategias claras
para mediación y solución de conflictos y éstos se resuelven a través del diálogo y la negociación permanente. Esto contribuye a que exista un buen clima laboral.',
                'valor' => 3,
                'indice_calificacion' => '3.4.9'
            ],
            [
                'descripcion' => 'El consejo académico está conformado en el marco de la integración institucional, y cuenta con una metodología de
trabajo orientada al diseño y la
implementación del proyecto
pedagógico. Sin embargo, no
se reúne con regularidad o no
asisten todos sus miembros,
afectando negativamente las
decisiones.',
                'valor' => 2,
                'indice_calificacion' => '1.3.2'
            ],
            [
                'descripcion' => 'Los resultados de las evaluaciones externas son conocidos por los docentes, pero éstos no se utilizan para diseñar e implementar acciones de mejoramiento.',
                'valor' => 1,
                'indice_calificacion' => '2.4.2'
            ],
            [
                'descripcion' => 'La institución cuenta con una
política de dotación, uso y
mantenimiento de los recursos
para el aprendizaje y hay una
conexión clara entre el enfoque
metodológico y los criterios
administrativos.',
                'valor' => 2,
                'indice_calificacion' => '2.1.3'
            ],
            [
                'descripcion' => 'Los docentes cuentan con una
herramienta de planeación
muy general en la que se explicitan: los contenidos del
aprendizaje; los logros; y los recursos didácticos.',
                'valor' => 1,
                'indice_calificacion' => '2.3.2'
            ],
            [
                'descripcion' => 'El proceso de evaluación de docentes, directivos
y personal administrativo permite la implementación
de acciones de mejoramiento y de desarrollo profesional. Además, es conocido por la comunidad y cuenta con un respaldo amplio de los miembros de la institución.',
                'valor' => 3,
                'indice_calificacion' => '3.4.6'
            ],
            [
                'descripcion' => 'La institución asegura que la inclusión y la calidad sean el centro de su desarrollo, lo cual se ve reflejado en la misión, la visión y los principios están claramente definidos para la institución integrada e inclusiva y son revisados y ajustados periódicamente, en función de los nuevos retos externos y de las necesidades de los estudiantes.',
                'valor' => 4,
                'indice_calificacion' => '1.1.1'
            ],
            [
                'descripcion' => 'Las prácticas pedagógicas se basan en la comunicación, la cogestión del aprendizaje y la relación afectiva y la valoración de la diversidad de los estudiantes, como elementos facilitadores del proceso de enseñanza-aprendizaje, y esto se evidencia en la organización del aula, en las relaciones recíprocas y en las estrategias de aprendizaje utilizadas.',
                'valor' => 3,
                'indice_calificacion' => '2.3.1'
            ],
            [
                'descripcion' => 'La institución trabaja los temas
de prevención de riesgos físicos (accidentes caseros, disposición
de desechos, ergonomía, etc.) de manera parcial y esporádica.',
                'valor' => 1,
                'indice_calificacion' => '4.4.1'
            ],
            [
                'descripcion' => 'La institución evalúa el impacto de las alianzas y acuerdos con diferentes entidades, y los ajusta en concordancia con los resultados obtenidos.',
                'valor' => 4,
                'indice_calificacion' => '1.6.3'
            ],
            [
                'descripcion' => 'La institución posee mecanismos aislados para ejecutar el control de las horas efectivas de clase recibidas por los estudiantes.',
                'valor' => 1,
                'indice_calificacion' => '2.1.4'
            ],
            [
                'descripcion' => 'Los programas de prevención de riesgos físicos son reconocidos por la comunidad y sus beneficios irradian hacia los hogares el mejoramiento de las condiciones de seguridad.
Se orientan a la formación de la cultura del autocuidado, la solidaridad y la prevención frente a las condiciones de riesgo físico a las que pueden estar expuestos los miembros de la comunidad.',
                'valor' => 3,
                'indice_calificacion' => '4.4.1'
            ],
            [
                'descripcion' => 'Los planes, proyectos y acciones se enmarcan
en principios de corresponsabilidad, participación
y equidad, articulados al planteamiento
estratégico de la institución integrada e inclusiva,
y son conocidos por la comunidad educativa.
Se trabaja en equipo para articular las acciones.',
                'valor' => 3,
                'indice_calificacion' => '1.2.2'
            ],
            [
                'descripcion' => 'La institución revisa permanentemente si el personal vinculado está identificado con su filosofía, principios, valores y objetivos, y toma medidas pertinentes para lograr que todos se sientan parte
de la misma.',
                'valor' => 4,
                'indice_calificacion' => '3.4.5'
            ],
            [
                'descripcion' => 'La institución cuenta con mecanismos que le permiten conocer las necesidades y expectativas de todos los estudiantes y divulga esta información en su comunidad; los estudiantes encuentran elementos de identificación con la institución.',
                'valor' => 3,
                'indice_calificacion' => '4.1.3'
            ],
            [
                'descripcion' => 'La institución reconoce que las tareas escolares tienen una gran importancia pedagógica; sin embargo, los docentes las manejanvcbajo criterios individuales.',
                'valor' => 1,
                'indice_calificacion' => '2.2.2'
            ],
            [
                'descripcion' => 'La estrategia de promoción de la inclusión de
personas de diferentes grupos poblacionales
o diversidad cultural es la base para que
se adapten metodologías y espacios físicos,
apoyar talentos y hacerlos valorar por todos
los estamentos de la comunidad educativa.
Además, promueve la coordinación con otros
organismos para su atención integral.',
                'valor' => 3,
                'indice_calificacion' => '1.1.4'
            ],
            [
                'descripcion' => 'La institución ha implementado
un proceso de evaluación de
desempeño para docentes, directivos
y personal administrativo
que indaga los diferentes
aspectos en el desarrollo del
cargo. Este proceso cuenta con
indicadores y referentes claros
que están en concordancia con
la normatividad vigente, y son
conocidos por todos.',
                'valor' => 2,
                'indice_calificacion' => '3.4.6'
            ],
            [
                'descripcion' => 'Los criterios básicos sobre el manejo del establecimiento educativo y la atención a la diversidad fueron definidos de manera participativa y permiten el trabajo en equipo, pero no han sido evaluados para establecer su eficacia.',
                'valor' => 3,
                'indice_calificacion' => '1.2.1'
            ],
            [
                'descripcion' => 'La institución cuenta con un proceso de matrícula ágil y oportuno que tiene en cuenta las necesidades de los estudiantes y los padres de familia, y que es reconocido por la comunidad
educativa.',
                'valor' => 3,
                'indice_calificacion' => '3.1.1'
            ],
            [
                'descripcion' => 'La institución ha delineado
políticas para atender a poblaciones con requerimientos especiales, pero carece de información
relativa a las necesidades
de su localidad o municipio.',
                'valor' => 1,
                'indice_calificacion' => '4.1.1'
            ],
            [
                'descripcion' => 'La institución tiene un sistema de estímulos y reconocimientos a los logros de los docentes y estudiantes que se aplica de manera coherente, sistemática y organizada. Además, este sistema cuenta con el reconocimiento de la comunidad educativa y es parte de la cultura, las políticas y practicas inclusivas.',
                'valor' => 3,
                'indice_calificacion' => '1.4.3'
            ],
            [
                'descripcion' => 'La institución realiza su autoevaluación
sin un procedimiento claramente establecido;
la recolección de información y la evaluación se hacen sobre la marcha. Además, cada sede tiene su propio proceso de evaluación.',
                'valor' => 1,
                'indice_calificacion' => '1.2.5'
            ],
            [
                'descripcion' => 'El personero elegido desarrolla proyectos y programas a favor de todas y todos los estudiantes
y su labor es reconocida en los diferentes estamentos de la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.3.6'
            ],
            [
                'descripcion' => 'La mayoría de los estudiantes
de la institución manifiesta entusiasmo y ganas de aprender.',
                'valor' => 2,
                'indice_calificacion' => '1.5.4'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente el cumplimiento de las horas efectivas de clase recibidas por los estudiantes y toma las medidas pertinentes para corregir situaciones anómalas.',
                'valor' => 4,
                'indice_calificacion' => '2.1.4'
            ],
            [
                'descripcion' => 'El consejo estudiantil se reúne periódicamente y es reconocido como la instancia de representación
de los intereses de todos y todas los
estudiantes de la institución.',
                'valor' => 3,
                'indice_calificacion' => '1.3.5'
            ],
            [
                'descripcion' => 'La institución presenta los informes
financieros a las autoridades
competentes de manera
apropiada y oportuna, y
también los da a conocer a la
comunidad educativa. Sin embargo,
no los utiliza para apoyar
la toma de decisiones.',
                'valor' => 2,
                'indice_calificacion' => '3.5.4'
            ],
            [
                'descripcion' => 'La institución cuenta con alianzas y acuerdos con diferentes entidades para apoyar la ejecución de sus proyectos. Además, tales alianzas y acuerdos cuentan con la participación de los diferentes estamentos de la comunidad educativa
y sectores de la comunidad general.',
                'valor' => 3,
                'indice_calificacion' => '1.6.3'
            ],
            [
                'descripcion' => 'La institución revisa periódicamente la implementación de su política de evaluación tanto en cuanto a su aplicación por parte de los docentes, como en su efecto sobre la diversidad de los estudiantes, e introduce los ajustes pertinentes.',
                'valor' => 4,
                'indice_calificacion' => '2.1.5'
            ],
            [
                'descripcion' => 'La institución tiene un sistema de archivo que le permite disponer de la información de los estudiantes de todas las sedes, así como expedir constancias y certificados de manera ágil, confiable y oportuna.',
                'valor' => 3,
                'indice_calificacion' => '3.1.2'
            ],
            [
                'descripcion' => 'Está conformado el consejo de
padres de familia, pero éste no
se reúne para deliberar sobre
los temas de su competencia.',
                'valor' => 1,
                'indice_calificacion' => '1.3.8'
            ],
            [
                'descripcion' => 'El consejo de padres de familia se reúne periódicamente para apoyar al rector o director en el marco del plan de mejoramiento. Sin embargo, no hace seguimiento sistemático a los resultados obtenidos.',
                'valor' => 3,
                'indice_calificacion' => '1.3.8'
            ],
            [
                'descripcion' => 'La institución revisa periódicamente sus estrategias de mediación de conflictos y los ajusta de acuerdo con las necesidades.',
                'valor' => 4,
                'indice_calificacion' => '3.4.9'
            ],
            [
                'descripcion' => 'La institución conoce los requerimientos
educativos de las poblaciones o personas que experimentan barreras para el aprendizaje y la participación en su entorno y ha diseñado planes de trabajo pedagógico para atenderlas en concordancia con el PEI y la normatividad vigente.',
                'valor' => 2,
                'indice_calificacion' => '4.1.1'
            ],
            [
                'descripcion' => 'Hay un plan de estudios institucional que cuenta con proyectos pedagógicos y contenidos transversales, y en su elaboración se tuvieron en cuenta las características del entorno, la diversidad de la población, el PEI, los lineamientos curriculares y los estándares básicos de competencias establecidos por el MEN.',
                'valor' => 2,
                'indice_calificacion' => '2.1.1'
            ],
            [
                'descripcion' => 'La institución realiza seguimiento a la incidencia de los resultados de las evaluaciones externas en la planeación de los docentes en cada área y grado y promueve acciones correctivas para su ajuste en el plan de mejoramiento de las áreas.',
                'valor' => 4,
                'indice_calificacion' => '2.4.2'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente el sistema de estímulos y reconocimientos de los logros de los docentes y estudiantes, y hace los ajustes pertinentes para cualificarlo.',
                'valor' => 4,
                'indice_calificacion' => '1.4.3'
            ],
            [
                'descripcion' => 'Las metas están formuladas
solamente para algunas sedes.
Además, ninguna o sólo
algunas son cuantificables y
responden a unos propósitos
claros de mejoramiento.',
                'valor' => 1,
                'indice_calificacion' => '1.1.2'
            ],
            [
                'descripcion' => 'La institución cuenta con políticas
y mecanismos para abordar
los casos de bajo rendimiento
y problemas de aprendizaje,
pero no se hace seguimiento a
los mismos, ni se acude a recursos
externos.',
                'valor' => 2,
                'indice_calificacion' => '2.4.5'
            ],
            [
                'descripcion' => 'La institución cuenta con una política de comunicación e interacción con las autoridades educativas, y se han establecido los canales, el tipo y la periodicidad de la información.',
                'valor' => 2,
                'indice_calificacion' => '1.6.2'
            ],
            [
                'descripcion' => 'Los programas de prevención que se llevan a cabo son evaluados, así como los mecanismos de información y análisis de los factores de riesgo psicosocial, con el fin de fortalecerlos, y por esa vía mejorar los modelos de intervención que tiene la institución.',
                'valor' => 4,
                'indice_calificacion' => '4.4.2'
            ],
            [
                'descripcion' => 'La institución cuenta con un
sistema de archivo organizado
donde se integra la información
histórica de los estudiantes
de todas las sedes.',
                'valor' => 2,
                'indice_calificacion' => '3.1.2'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa periódicamente los resultados de los programas de apoyo pedagógico
que realiza e implementa acciones correctivas, tendientes a mejorar los resultados de los estudiantes.',
                'valor' => 4,
                'indice_calificacion' => '2.4.5'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa las políticas, procesos de comunicación e intercambio con las familias o acudientes y, con base en estos resultados, realiza los ajustes pertinentes.',
                'valor' => 4,
                'indice_calificacion' => '1.6.1'
            ],
            [
                'descripcion' => 'La institución ha definido estrategias
para la mediación de
conflictos, pero éstas se usan
de manera esporádica y no
abarcan la totalidad de sedes,
grados o niveles.',
                'valor' => 2,
                'indice_calificacion' => '3.4.9'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente su estrategia de inclusión de personas de diferentes grupos poblacionales o diversidad cultural, e introduce los ajustes pertinentes para fortalecerla.',
                'valor' => 4,
                'indice_calificacion' => '1.1.4'
            ],
            [
                'descripcion' => 'La escuela de padres es un
programa pedagógico institucional que orienta a los integrantes de la familia respecto de la mejor manera de ayudar a sus hijos en el desarrollo de competencias académicas o sociales y apoyar la institución en sus diferentes procesos.',
                'valor' => 2,
                'indice_calificacion' => '4.2.1'
            ],
            [
                'descripcion' => 'La institución revisa y hace seguimiento a los resultados de los informes financieros, para que éstos sean un elemento clave en el momento de
planear las acciones, tomar decisiones y evaluar los resultados de las mismas.',
                'valor' => 4,
                'indice_calificacion' => '3.5.4'
            ],
            [
                'descripcion' => 'El personal vinculado está identificado con la
institución: comparte la filosofía, principios,
valores y objetivos, y está dispuesto a realizar
actividades complementarias que sean necesarias para cualificar su labor.',
                'valor' => 3,
                'indice_calificacion' => '3.4.5'
            ],
            [
                'descripcion' => 'La institución tiene una política
sobre el uso de los recursos
para el aprendizaje, pero ésta
no está articulada con la propuesta
pedagógica.',
                'valor' => 1,
                'indice_calificacion' => '2.2.3'
            ],
            [
                'descripcion' => 'Los procesos de inclusión de personas de diferentes grupos poblacionales o diversidad
cultural están bajo la responsabilidad de cada sede; no responden a una estrategia institucional articulada y conocida por todos los estamentos de la comunidad educativa.',
                'valor' => 1,
                'indice_calificacion' => '1.1.4'
            ],
            [
                'descripcion' => 'La institución cuenta con una
política para desarrollar el proceso de matrícula que garantiza su agilidad y coherencia con los lineamientos nacionales y
locales.',
                'valor' => 2,
                'indice_calificacion' => '3.1.1'
            ],
            [
                'descripcion' => 'El plan de estudios es articulado y coherente. Además, cuenta con mecanismos de seguimiento y retroalimentación, a partir de los cuales se mantienen su pertinencia, relevancia y calidad.',
                'valor' => 4,
                'indice_calificacion' => '2.1.1'
            ],
            [
                'descripcion' => 'El plan de estudios es un agregado
de planes de área elaborados de forma aislada e individual, sin coherencia con lo estipulado en el PEI.',
                'valor' => 1,
                'indice_calificacion' => '2.1.1'
            ],
            [
                'descripcion' => 'La institución tiene una política sobre el uso de los recursos para el aprendizaje que está articulada con su propuesta pedagógica. Además, ésta es aplicada por todos.',
                'valor' => 3,
                'indice_calificacion' => '2.2.3'
            ],
            [
                'descripcion' => 'La institución conoce las características
de su entorno y procura dar respuestas a éstas mediante acciones que buscan
acercar los estudiantes a la institución,
en concordancia con el PEI.',
                'valor' => 2,
                'indice_calificacion' => '4.1.3'
            ],
            [
                'descripcion' => 'La evaluación del desempeño
académico de los estudiantes
responde a criterios individuales
o de áreas.',
                'valor' => 1,
                'indice_calificacion' => '2.1.5'
            ],
            [
                'descripcion' => 'La institución realiza un intercambio fluido de
información con las autoridades educativas
en el marco de la política definida, lo que facilita la ejecución de las actividades y la solución oportuna de los problemas.',
                'valor' => 3,
                'indice_calificacion' => '1.6.2'
            ],
            [
                'descripcion' => 'La institución cuenta con programas
definidos para algunos servicios complementarios, y los presta con la calidad y la regularidad necesarias para atender los requerimientos del
estudiantado. Además, hay una articulación con la oferta externa.',
                'valor' => 2,
                'indice_calificacion' => '3.3.1'
            ],
            [
                'descripcion' => 'La institución desarrolla actividades
para la comunidad en respuesta a situaciones o problemas críticos, y ésta es la receptora de sus acciones.',
                'valor' => 1,
                'indice_calificacion' => '4.2.2'
            ],
            [
                'descripcion' => 'El consejo estudiantil está conformado
mediante elección democrática, pero no se reúne periódicamente para deliberar y tomar las decisiones que le corresponden.',
                'valor' => 2,
                'indice_calificacion' => '1.3.5'
            ],
            [
                'descripcion' => 'Casi todas las sedes de la institución
poseen espacios suficientes para realizar las labores académicas, administrativas y recreativas, y éstas se mantienen limpias y ordenadas. La dotación es adecuada. Esto genera sentimientos de apropiación y cuidado hacia los mismos.',
                'valor' => 2,
                'indice_calificacion' => '1.5.2'
            ],
            [
                'descripcion' => 'La institución cuenta con una
política de comunicación e
interacción con las familias o
acudientes y se han establecido
los canales, el tipo y la periodicidad de la información.',
                'valor' => 2,
                'indice_calificacion' => '1.6.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente los procedimientos para la elaboración del presupuesto, de manera que se logre coordinar las necesidades de las distintas sedes y niveles. Asimismo, realiza
análisis financieros y proyecciones presupuestales para la planeación y gestión institucional.',
                'valor' => 4,
                'indice_calificacion' => '3.5.1'
            ],
            [
                'descripcion' => 'Los planes de clases desarrollan
el plan de estudios y allí se
definen: los contenidos del
aprendizaje; los logros; el rol del docente y del estudiante; la elección y uso de
los recursos didácticos; los
medios, momentos y criterios
para la evaluación; y los
estándares de referencia. Sin
embargo, éstos no son aplicados
en todas las sedes, niveles,
áreas o grados.',
                'valor' => 2,
                'indice_calificacion' => '2.3.2'
            ],
            [
                'descripcion' => 'La institución cuenta con programas de apoyo pedagógico a los casos de bajo rendimiento académico, así como con mecanismos de seguimiento, actividades institucionales y soporte
interinstitucional.',
                'valor' => 3,
                'indice_calificacion' => '2.4.5'
            ],
            [
                'descripcion' => 'Los equipos docentes han realizado
esfuerzos coordinados
para apoyar el proceso de
enseñanza-aprendizaje en la
comunicación recíproca, las
relaciones horizontales y la negociación
con los estudiantes.',
                'valor' => 2,
                'indice_calificacion' => '2.3.1'
            ],
            [
                'descripcion' => 'El sistema de evaluación del desempeño de los estudiantes se aplica permanentemente, se realiza seguimiento a los estudiantes con bajo desempeño y es conocido por los padres de familia.',
                'valor' => 3,
                'indice_calificacion' => '2.3.4'
            ],
            [
                'descripcion' => 'La institución implementa un proceso de autoevaluación integral a partir de los resultados de las evaluaciones internas y externas, y las evaluaciones de desempeño de los docentes y personal administrativo que abarca las diferentes sedes, empleando instrumentos y procedimientos claros. Además, cuenta con la participación de los diferentes estamentos de la comunidad educativa cuyo resultados se evidencia en el plan de mejoramiento institucional y la resignificación del PEI.',
                'valor' => 3,
                'indice_calificacion' => '1.2.5'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa periódicamente la efectividad de su política relativa a las actividades
curriculares y realiza los ajustes pertinentes a la misma para garantizar la participación de todos.',
                'valor' => 4,
                'indice_calificacion' => '1.5.6'
            ],
            [
                'descripcion' => 'La institución tiene una política de evaluación
fundamentada en los lineamientos curriculares,
los estándares básicos de competencias y los
artículos 2° y 3° del Decreto 230 de 2002 y el
articulo 8 del decreto 2082 de 1996, la cual se
refleja en las prácticas de los docentes.',
                'valor' => 3,
                'indice_calificacion' => '2.1.5'
            ],
            [
                'descripcion' => 'Algunas sedes realizan actividades
extracurriculares , pero éstas no se enmarcan en
una política institucional.',
                'valor' => 1,
                'indice_calificacion' => '1.5.6'
            ],
            [
                'descripcion' => 'La institución utiliza diferentes medios de comunicación, previamente identificados, para informar, actualizar y motivar a cada uno de los estamentos de la comunidad educativa en el proceso de mejoramiento institucional. Reconoce y garantiza el acceso a los medios de comunicación, ajustados a las necesidades de la diversidad de la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.4.1'
            ],
            [
                'descripcion' => 'El seguimiento que se hace a los desempeños de los estudiantes es aislado e individual, y no se generan acciones concretas para el logro de las competencias.',
                'valor' => 1,
                'indice_calificacion' => '2.4.1'
            ],
            [
                'descripcion' => 'Las prácticas pedagógicas de aula de los docentes de todas las áreas, grados y sedes desarrollan el enfoque metodológico común en cuanto a métodos de enseñanza flexibles, relación pedagógica y uso de recursos que respondan a la diversidad de la población.',
                'valor' => 3,
                'indice_calificacion' => '2.1.6'
            ],
            [
                'descripcion' => 'Ocasionalmente se han establecido
procesos administrativos para la dotación, el uso y el mantenimiento de los recursos para el aprendizaje. Cuando existen, se aplican esporádicamente.',
                'valor' => 1,
                'indice_calificacion' => '2.1.3'
            ],
            [
                'descripcion' => 'La institución realiza reuniones
ocasionales para identificar y
socializar los mejores desempeños en el ámbito pedagógico y administrativo.',
                'valor' => 1,
                'indice_calificacion' => '1.4.4'
            ],
            [
                'descripcion' => 'El consejo académico está
conformado pero tiene escasa
incidencia en el diseño e
implementación del proyecto
pedagógico; sus miembros se
reúnen ocasionalmente y, en
la mayoría de casos, se atienden
prioritariamente asuntos
administrativos. En algunos
casos, cada sede tiene su propio
consejo académico.',
                'valor' => 1,
                'indice_calificacion' => '1.3.2'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa periódicamente la articulación entre la política sobre el uso de los recursos para el aprendizaje y su propuesta pedagógica, y realiza ajustes a la misma con base en los resultados de los estudiantes.',
                'valor' => 4,
                'indice_calificacion' => '2.2.3'
            ],
            [
                'descripcion' => 'Los modelos pedagógicos diseñados para la atención a la población que xperimenta barreras para el aprendizaje y la participación y los mecanismos de seguimiento a estas demandas son evaluados permanentemente con el propósito de mejorar la oferta y la calidad del servicio prestado.
La institución es sensible a las necesidades de su entorno y busca adecuar su oferta educativa a tales demandas.',
                'valor' => 4,
                'indice_calificacion' => '4.1.1'
            ],
            [
                'descripcion' => 'La institución revisa periódicamente el manual de convivencia en relación con su papel en la gestión
del clima institucional y orienta los ajustes y mejoramientos al mismo.',
                'valor' => 4,
                'indice_calificacion' => '1.5.5'
            ],
            [
                'descripcion' => 'Hay metas establecidas para
la institución integrada e inclusiva, pero solamente algunas responden a sus objetivos y al direccionamiento estratégico.',
                'valor' => 2,
                'indice_calificacion' => '1.1.2'
            ],
            [
                'descripcion' => 'La institución hace seguimiento a las relaciones de aula, y diseña e implementa acciones de mejoramiento para contrarrestar las debilidades evidenciadas.',
                'valor' => 4,
                'indice_calificacion' => '2.3.1'
            ],
            [
                'descripcion' => 'La institución evalúa y mejora el uso de los diferentes medios de comunicación empleados, en función del reconocimiento y la aceptación de los diferentes estamentos de la comunidad educativa.',
                'valor' => 4,
                'indice_calificacion' => '1.4.1'
            ],
            [
                'descripcion' => 'La institución cuenta con una estrategia de
interacción con la comunidad que orienta,
da sentido a las acciones que se planean conjuntamente y dan respuesta a problemáticas y necesidades que apuntan al mejoramiento de las condiciones de vida de la comunidad y los estudiantes',
                'valor' => 3,
                'indice_calificacion' => '4.2.2'
            ],
            [
                'descripcion' => 'La institución establece comunicaciones
con las autoridades educativas locales en función de las necesidades que se presenten.
En general, cada sede posee sus propios canales de comunicación.',
                'valor' => 1,
                'indice_calificacion' => '1.6.2'
            ],
            [
                'descripcion' => 'La comunidad educativa reconoce y utiliza el
comité de convivencia para identificar y mediar
los conflictos. Las actividades programadas
para fortalecer la convivencia cuentan con
amplia participación de los distintos estamentos
de la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.5.8'
            ],
            [
                'descripcion' => 'Existen en la institución algunas
iniciativas para apoyar a los estudiantes en la formulación
de sus proyectos de vida, pero éstas no están articuladas a otros procesos.',
                'valor' => 1,
                'indice_calificacion' => '4.1.4'
            ],
            [
                'descripcion' => 'La institución evalúa periódica y sistemáticamente el impacto que tienen la socialización, la documentación y la apropiación de buenas prácticas y realiza los ajustes pertinentes.',
                'valor' => 4,
                'indice_calificacion' => '1.4.4'
            ],
            [
                'descripcion' => 'Por iniciativa individual, algunos
docentes se ocupan de los
casos de bajo rendimiento y
problemas de aprendizaje de
los estudiantes.',
                'valor' => 1,
                'indice_calificacion' => '2.4.5'
            ],
            [
                'descripcion' => 'Pocos estudiantes de algunas sedes, niveles o grados manifiestan entusiasmo y ganas de aprender.',
                'valor' => 1,
                'indice_calificacion' => '1.5.4'
            ],
            [
                'descripcion' => 'Hay un reconocimiento de la
importancia de la interacción
pedagógica como un pilar del
proceso educativo; sin embargo,
la organización del trabajo
de aula privilegia la relación
unilateral con el docente.',
                'valor' => 1,
                'indice_calificacion' => '2.3.1'
            ],
            [
                'descripcion' => 'El gobierno escolar evalúa el impacto de la labor del personero y a partir de ésta se mejoran los procesos de elección y participación del estudiantado.',
                'valor' => 4,
                'indice_calificacion' => '1.3.6'
            ],
            [
                'descripcion' => 'La institución cuenta con mecanismos
claros, articulados y sistemáticos para realizar el seguimiento de las horas efectivas de clase recibidas por los
estudiantes.',
                'valor' => 2,
                'indice_calificacion' => '2.1.4'
            ],
            [
                'descripcion' => 'Los perfiles con que cuenta la institución se
usan para la toma de decisiones de personal
y son coherentes con su estructura organizativa.
Además, su uso en procesos de selección,
solicitud e inducción del personal facilita el
desempeño de las personas que se vinculan
laboralmente a la institución.',
                'valor' => 3,
                'indice_calificacion' => '3.4.1'
            ],
            [
                'descripcion' => 'La institución evalúa y mejora los procesos relacionados con los proyectos de vida de sus estudiantes, de modo que hay un interés por cualificar este aspecto en la formación de sus alumnos.',
                'valor' => 4,
                'indice_calificacion' => '4.1.4'
            ],
            [
                'descripcion' => 'El consejo estudiantil se reúne periódicamente y cuenta con el aporte activo de todos sus miembros.
Además, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo.',
                'valor' => 4,
                'indice_calificacion' => '1.3.5'
            ],
            [
                'descripcion' => 'El proceso de matrícula se
desarrolla según los criterios
adoptados por cada una de las
sedes.',
                'valor' => 1,
                'indice_calificacion' => '3.1.1'
            ],
            [
                'descripcion' => 'El comité de convivencia se reúne periódicamente y cuenta con el aporte activo de todos sus miembros. Además, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo.',
                'valor' => 4,
                'indice_calificacion' => '1.3.4'
            ],
            [
                'descripcion' => 'La institución realiza evaluaciones
de desempeño de docentes,
directivos y personal
administrativo de forma esporádica
y sin contar con un
modelo evaluativo para este
propósito.',
                'valor' => 1,
                'indice_calificacion' => '3.4.6'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa continuamente su programa de formación y capacitación en función de su incidencia en el mejoramiento de los procesos de enseñanza y aprendizaje y en el desarrollo institucional.',
                'valor' => 4,
                'indice_calificacion' => '3.4.3'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa continuamente la definición de los perfiles y su uso en los procesos de selección, solicitud e inducción del personal, en función del plan de mejoramiento y de sus necesidades.',
                'valor' => 4,
                'indice_calificacion' => '3.4.1'
            ],
            [
                'descripcion' => 'La contabilidad de la institución
se organiza de acuerdo
con los requisitos reglamentarios
y discrimina claramente
los servicios prestados. Sin
embargo, su uso se limita a la
elaboración de informes para
los organismos de control, de
modo que no se cuenta con
esta información como instrumento
de análisis financiero.',
                'valor' => 2,
                'indice_calificacion' => '3.5.2'
            ],
            [
                'descripcion' => 'ELa institución ofrece algunos
servicios complementarios esporádicamente y su cobertura
es insuficiente.',
                'valor' => 1,
                'indice_calificacion' => '3.3.1'
            ],
            [
                'descripcion' => 'Existen estrategias de comunicación
que permiten que la institución y la comunidad se conozcan mutuamente; las actividades se organizan de manera
conjunta, así no guarden estrecha relación con el PEI.',
                'valor' => 2,
                'indice_calificacion' => '4.2.2'
            ],
            [
                'descripcion' => 'La institución tiene una estrategia articulada para promover inclusión de personas de
diferentes grupos poblacionales o diversidad cultural, que es conocida por todos los
estamentos de la comunidad educativa para direccionar las acciones en este sentido.',
                'valor' => 2,
                'indice_calificacion' => '1.1.4'
            ],
            [
                'descripcion' => 'La institución cuenta con perfiles
poco específicos que no
orientan con claridad el proceso
de selección o solicitud de
personal.',
                'valor' => 1,
                'indice_calificacion' => '3.4.1'
            ],
            [
                'descripcion' => 'Las estrategias de evaluación del desempeño de los estudiantes son conocidas por la comunidad educativa y diseñadas teniendo en cuenta los niveles de competencia a alcanzar en cada grado y nivel, pero se aplican ocasionalmente.',
                'valor' => 2,
                'indice_calificacion' => '2.3.4'
            ],
            [
                'descripcion' => 'El consejo académico se reúne ordinariamente y cuenta con el aporte activo de todos sus miembros. Allí se toman decisiones sobre los procesos
pedagógicos y se hace seguimiento sistemático al plan de trabajo, para asegurar su cumplimiento.',
                'valor' => 4,
                'indice_calificacion' => '1.3.2'
            ],
            [
                'descripcion' => 'La institución realiza un intercambio muy ágil
y fluido de información con las familias o acudientes
en el marco de la política definida, lo
que facilita la solución oportuna de los problemas.',
                'valor' => 3,
                'indice_calificacion' => '1.6.1'
            ],
            [
                'descripcion' => 'La institución cuenta con un enfoque metodológico que hacen explícitos los acuerdos básicos relativos a métodos de enseñanza, relación pedagógica y usos de recursos que responde a las características de la diversidad de la población.',
                'valor' => 2,
                'indice_calificacion' => '2.1.6'
            ],
            [
                'descripcion' => 'La institución no cuenta con
información adecuadamente
sistematizada respecto de las
necesidades y expectativas de
los estudiantes; por ello, su
sentido de pertenencia es bajo
y es alta la incidencia del ausentismo y la deserción.',
                'valor' => 1,
                'indice_calificacion' => '4.1.3'
            ],
            [
                'descripcion' => 'La institución asegura los recursos para cumplir el programa de mantenimiento de su planta física.',
                'valor' => 3,
                'indice_calificacion' => '3.2.1'
            ],
            [
                'descripcion' => 'La contabilidad tiene todos sus soportes; los informes financieros se elaboran y se presentan dentro de los plazos establecidos por las normas y se usan para el control financiero y para la toma
de decisiones en el corto, mediano y largo plazo.
Sus resultados aportan información para ajustar los planes de mejoramiento.',
                'valor' => 4,
                'indice_calificacion' => '3.5.2'
            ],
            [
                'descripcion' => 'Los planes, proyectos y acciones
se elaboran y se implementan
de manera aislada, y
no responden claramente al
planteamiento estratégico. La
articulación de los mismos en
las diferentes sedes es inexistente
o incipiente.',
                'valor' => 1,
                'indice_calificacion' => '1.2.2'
            ],
            [
                'descripcion' => 'En el marco del SIEE de la institución educativa, los docentes aplican estrategias para evaluar los desempeños de los estudiantes de manera aislada y no son conocidas por los padres de familia.',
                'valor' => 1,
                'indice_calificacion' => '2.3.4'
            ],
            [
                'descripcion' => 'La institución evalúa y ajusta el funcionamiento del comité de convivencia, recupera la información
relativa a las estrategias exitosas para el manejo de conflictos y el desarrollo de competencias para la convivencia y el respeto a la diversidad.
Además, propicia su transferencia y apropiación.',
                'valor' => 4,
                'indice_calificacion' => '1.5.8'
            ],
            [
                'descripcion' => 'Se evalúan periódicamente los aspectos relativos a la identificación de los estudiantes con la institución y al fortalecimiento de su sentimiento de pertenencia, y se introducen medidas oportunas para promover y reforzar este sentimiento.',
                'valor' => 4,
                'indice_calificacion' => '1.5.1'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa las políticas, procesos de comunicación e intercambio con las autoridades
educativas y, con base en estos resultados, realiza los ajustes pertinentes.',
                'valor' => 4,
                'indice_calificacion' => '1.6.2'
            ],
            [
                'descripcion' => 'Al inicio del año escolar, en todas las sedes se explican a los estudiantes nuevos los usos y costumbres de la institución.',
                'valor' => 2,
                'indice_calificacion' => '1.5.3'
            ],
            [
                'descripcion' => 'La institución cuenta con políticas y programas claros que recogen las expectativas de todos los estudiantes y ofrece alternativas para que se identifiquen con ella. Los mecanismos empleados para hacer el seguimiento a las necesidades de los estudiantes y ponderar su grado de satisfacción se
evalúan y mejoran constantemente y sus resultados retroalimentan el plan de mejoramiento institucional.',
                'valor' => 4,
                'indice_calificacion' => '4.1.3'
            ],
            [
                'descripcion' => 'La institución ha implementado un rocedimiento para identificar, divulgar y documentar las buenas prácticas pedagógicas, administrativas y culturales que reconocen la diversidad de la población en todos sus componentes de gestión. El intercambio de experiencias propicia acciones de mejoramiento.',
                'valor' => 3,
                'indice_calificacion' => '1.4.4'
            ],
            [
                'descripcion' => 'Los servicios complementarios y recursos que
ofrece la comunidad y los Establecimientos
Educativos, se distribuyen de forma equitativa, se ofrecen oportunamente teniendo en cuenta la calidad requerida . Cada sede tiene programas sensibles a las demandas de los
estudiantes, y la institución cuenta con el apoyo de otras entidades para su prestación.',
                'valor' => 3,
                'indice_calificacion' => '3.3.1'
            ],
            [
                'descripcion' => 'Está conformada la asamblea
de padres de familia, pero ésta
no se reúne periódicamente
para deliberar y tomar decisiones
sobre los temas de su competencia.',
                'valor' => 2,
                'indice_calificacion' => '1.3.7'
            ],
            [
                'descripcion' => 'Todas las metas establecidas para la institución integrada e inclusiva responden a sus objetivos y al direccionamiento estratégico. Además, éstas son conocidas y puestas en práctica por la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.1.2'
            ],
            [
                'descripcion' => 'Los perfiles se encuentran bien
definidos, son coherentes con
el PEI y con la normatividad
vigente; sin embargo, no son
tenidos en cuenta en los procesos
de selección, solicitud e
inducción del personal.',
                'valor' => 2,
                'indice_calificacion' => '3.4.1'
            ],
            [
                'descripcion' => 'La institución tiene un plan para adquisición
de los recursos para el aprendizaje que garantiza la disponibilidad oportuna de los mismos dirigidos a prevenir las barreras y potenciar la participación de todos los estudiantes, en concordancia con el direccionamiento estratégico y las necesidades de los docentes y estudiantes.',
                'valor' => 3,
                'indice_calificacion' => '3.2.4'
            ],
            [
                'descripcion' => 'La institución cuenta con mecanismos parciales de comunicación entre los integrantes de la comunidad educativa.',
                'valor' => 1,
                'indice_calificacion' => '1.4.1'
            ],
            [
                'descripcion' => 'Hay algunos avances hacia la formulación de la misión,
la visión y los principios que orientan estratégicamente la
institución integrada e inclusiva, pero éstos todavía no están totalmente articulados.',
                'valor' => 2,
                'indice_calificacion' => '1.1.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente la disponibilidad y calidad de los recursos para el aprendizaje y realiza ajustes a su plan de adquisiciones.',
                'valor' => 4,
                'indice_calificacion' => '3.2.4'
            ],
            [
                'descripcion' => 'La institución hace evaluaciones periódicas sobre la satisfacción de de las familias y los estudiantes en relación con el proceso de matrícula y propicia el mejoramiento del mismo.',
                'valor' => 4,
                'indice_calificacion' => '3.1.1'
            ],
            [
                'descripcion' => 'El manual de convivencia es conocido y utilizado frecuentemente como un instrumento que orienta los principios, valores, estrategias y actuaciones que favorecen un clima organizacional armónico entre los diferentes integrantes de la comunidad educativa; fomentando el
respeto y la valoración de la diversidad.',
                'valor' => 3,
                'indice_calificacion' => '1.5.5'
            ],
            [
                'descripcion' => 'Se reconoce la existencia de la
asamblea de padres de familia,
pero esta no se reúne para
deliberar sobre los temas de su competencia.',
                'valor' => 1,
                'indice_calificacion' => '1.3.7'
            ],
            [
                'descripcion' => 'El comité de convivencia se reúne periódicamente y es reconocido como la instancia encargada de analizar y plantear soluciones a los problemas de convivencia que se presentan en la institución.',
                'valor' => 3,
                'indice_calificacion' => '1.3.4'
            ],
            [
                'descripcion' => 'El personal vinculado se identifica
solamente con algunos
aspectos de la misma, y ello
genera indiferencia hacia la
institución.',
                'valor' => 1,
                'indice_calificacion' => '3.4.5'
            ],
            [
                'descripcion' => 'La institución cuenta con un programa estructurado de inducción y de acogida, el cual está apoyado en materiales y estrategias que se adaptan a las condiciones personales, sociales y culturales de todos los integrantes. La inducción se hace al inicio del año escolar a todos los estudiantes nuevos y sus familias.',
                'valor' => 3,
                'indice_calificacion' => '1.5.3'
            ],
            [
                'descripcion' => 'La institución cuenta con una política
sobre el uso de los recursos para
el aprendizaje que está articulada
a su propuesta pedagógica, pero
ésta se aplica solamente en algunas
sedes, niveles o grados.',
                'valor' => 2,
                'indice_calificacion' => '2.2.3'
            ],
            [
                'descripcion' => 'La institución ha definido parcialmente
un enfoque metodológico que hace explícitos los métodos de enseñanza por áreas o grados.',
                'valor' => 1,
                'indice_calificacion' => '2.1.2'
            ],
            [
                'descripcion' => 'No se ha conformado su consejo
directivo como institución integrada; o bien se ha establecido formalmente, pero éste no funciona en la práctica.',
                'valor' => 1,
                'indice_calificacion' => '1.3.1'
            ],
            [
                'descripcion' => 'La asamblea de padres de familia se reúne periódicamente y es reconocida como la instancia de representación de estos integrantes de la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.3.7'
            ],
            [
                'descripcion' => 'El consejo directivo tiene una agenda y un cronograma de trabajo para orientar los procesos de planeación y el seguimiento a las acciones institucionales.
Sin embargo, no se reúne con regularidad.',
                'valor' => 2,
                'indice_calificacion' => '1.3.1'
            ],
            [
                'descripcion' => 'La institución cuenta con un enfoque metodológico que hacen explícitos los acuerdos básicos relativos a métodos de enseñanza, relación pedagógica y usos de recursos que responde a las características de la diversidad de la población.',
                'valor' => 2,
                'indice_calificacion' => '2.1.2'
            ],
            [
                'descripcion' => 'Hay una formulación incipiente o parcial del direccionamiento estratégico como institución integrada e inclusiva. Pueden estar prevaleciendo la misión, la visión o los principios de cada una de las distintas sedes.',
                'valor' => 1,
                'indice_calificacion' => '1.1.1'
            ],
            [
                'descripcion' => 'El consejo directivo se reúne periódicamente de acuerdo con un cronograma establecido y sesiona con el aporte activo de todos sus miembros. Hace seguimiento sistemático al plan de trabajo, para garantizar su cumplimiento.',
                'valor' => 4,
                'indice_calificacion' => '1.3.1'
            ],
            [
                'descripcion' => 'La institucion tiene una politica definida bcon respecto a las actividades extracurriculares, las cuales se articulan a los porcesos de formacion de los estudiantes. Sin embargo, estas solamente se aplica en algunas sedes',
                'valor' => 2,
                'indice_calificacion' => '1.5.6'
            ],
            [
                'descripcion' => 'Hay un personero, pero su
elección no cuenta con el aval
y reconocimiento de todas y
todos los estudiantes de las diferentes sedes.',
                'valor' => 1,
                'indice_calificacion' => '1.3.6'
            ],
            [
                'descripcion' => 'El consejo estudiantil está conformado mediante elección democrática, pero sus integrantes
no se reúnen ni se toman
las decisiones que son de
su competencia.',
                'valor' => 1,
                'indice_calificacion' => '1.3.5'
            ],
            [
                'descripcion' => 'La institución ofrece actividades
de prevención, tanto propias
como externas, sin que exista una relación entre los factores de riesgo de su comunidad y el contenido de las mismas. El análisis de los factores de riesgo se basa en anécdotas
y casos particulares.',
                'valor' => 1,
                'indice_calificacion' => '4.4.2'
            ],
            [
                'descripcion' => 'La institución cuenta con un
programa de mantenimiento
preventivo de su planta física.',
                'valor' => 2,
                'indice_calificacion' => '3.2.1'
            ],
            [
                'descripcion' => 'La institución cuenta con un
plan para la adquisición de los
recursos para el aprendizaje
que consulta las demandas de
su direccionamiento estratégico
y las necesidades de los docentes
y estudiantes.',
                'valor' => 2,
                'indice_calificacion' => '3.2.4'
            ],
            [
                'descripcion' => 'La contabilidad está disponible de manera
oportuna y los informes financieros permiten
realizar un control efectivo del presupuesto y
del plan de ingresos y gastos.',
                'valor' => 3,
                'indice_calificacion' => '3.5.2'
            ],
            [
                'descripcion' => 'Las alianzas con el sector productivo tienen objetivos y metodologías claras para apoyar el desarrollo de competencias en los estudiantes y se promueven procesos de seguimiento y evaluación periódicos.',
                'valor' => 3,
                'indice_calificacion' => '1.6.4'
            ],
            [
                'descripcion' => 'Una parte importante del
personal vinculado a la institución
comparte la filosofía,
principios, valores y objetivos y
dedica algún tiempo a la realización
de actividades relacionadas
con estos aspectos.',
                'valor' => 2,
                'indice_calificacion' => '3.4.5'
            ],
            [
                'descripcion' => 'Los docentes realizan seguimiento periódico a los desempeños de los estudiantes y diseñan algunas acciones de mejora a los mismos.',
                'valor' => 2,
                'indice_calificacion' => '2.4.1'
            ],
            [
                'descripcion' => 'La institución ha definido los
mecanismos de comunicación
de acuerdo con las características
y el tipo de información
pertinente para cada uno de
los estamentos de la comunidad
educativa.',
                'valor' => 2,
                'indice_calificacion' => '1.4.1'
            ],
            [
                'descripcion' => 'La institución revisa periódicamente el programa de mantenimiento de su planta física y realiza los ajustes pertinentes.',
                'valor' => 4,
                'indice_calificacion' => '3.2.1'
            ],
            [
                'descripcion' => 'Las prácticas pedagógicas de aula de los docentes de todas las áreas, grados y sedes desarrollan el enfoque metodológico común en cuanto a métodos de enseñanza flexibles, relación pedagógica y uso de recursos que respondan a la diversidad de la población.',
                'valor' => 3,
                'indice_calificacion' => '2.1.2'
            ],
            [
                'descripcion' => 'El análisis de los resultados de los estudiantes en las evaluaciones externas brinda información a los docentes para fortalecer los aprendizajes de los estudiantes.',
                'valor' => 2,
                'indice_calificacion' => '2.4.2'
            ],
            [
                'descripcion' => 'En todas las sedes de la institución se observan el entusiasmo y una elevada motivación hacia el aprendizaje, lo que se refleja en toda la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.5.4'
            ],
            [
                'descripcion' => 'La política institucional de dotación, uso y mantenimiento de los recursos para el aprendizaje permite apoyar el trabajo académico de la diversidad de sus estudiantes y docentes.',
                'valor' => 3,
                'indice_calificacion' => '2.1.3'
            ],
            [
                'descripcion' => 'El mantenimiento de la planta
física se realiza ocasionalmente,
sin obedecer a una planeación
sistemática.',
                'valor' => 1,
                'indice_calificacion' => '3.2.1'
            ],
            [
                'descripcion' => 'Existen procedimientos establecidos para que
las sedes y los niveles puedan elaborar el presupuesto
de forma acorde con las actividades
y metas establecidas en el Plan Operativo
Anual. Además, el plan de ingresos y egresos
está relacionado con los flujos de caja. El presupuesto
es un instrumento de planeación y
gestión financiera que opera coherentemente
con otros procesos institucionales.',
                'valor' => 3,
                'indice_calificacion' => '3.5.1'
            ],
            [
                'descripcion' => 'Los criterios básicos acerca del
manejo de la institución integrada
no están claramente definidos.
Por ello hay dificultades en
la coordinación entre las sedes y
problemas en la delegación de
tareas. Se trabaja aisladamente
y no siempre se llevan a término
los propósitos planteados.',
                'valor' => 1,
                'indice_calificacion' => '1.2.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente si sus espacios y dotaciones son suficientes, y si éstos propician un buen ambiente para el aprendizaje y la convivencia, sin que se constituyan en barreras para la participación de la comunidad educativa, así como para el desarrollo de actividades fuera de la jornada escolar.',
                'valor' => 4,
                'indice_calificacion' => '1.5.2'
            ],
            [
                'descripcion' => 'El consejo de padres de familia se reúne periódicamente y cuenta con la participación activa de todos sus miembros. Además, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo.',
                'valor' => 4,
                'indice_calificacion' => '1.3.8'
            ],
            [
                'descripcion' => 'El consejo de padres de familia
solamente se reúne esporádicamente
para trabajar sobre los asuntos de su competencia.',
                'valor' => 2,
                'indice_calificacion' => '1.3.8'
            ],
            [
                'descripcion' => 'La institución revisa continuamente el proceso de evaluación de docentes, directivos y personal administrativo, así como los resultados de las acciones de mejoramiento, con el fin de ajustarlos
y crear nuevos planes de incentivos, apoyo a la investigación, divulgación de buenas prácticas, etc.',
                'valor' => 4,
                'indice_calificacion' => '3.4.6'
            ],
            [
                'descripcion' => 'El presupuesto de la institución
es un agregado de ingresos y
gastos que no tiene relación
con las prioridades. No hay
mecanismos de planeación financiera.',
                'valor' => 1,
                'indice_calificacion' => '3.5.1'
            ],
            [
                'descripcion' => 'La mayoría de los estudiantes
de la institución manifiesta entusiasmo y ganas de aprender.',
                'valor' => 2,
                'indice_calificacion' => '1.5.5'
            ],
            [
                'descripcion' => 'La comunidad tiene participación en la vida institucional y hay procesos de seguimiento y evaluación de los programas y las actividades. Las alianzas con las organizaciones culturales, sociales, recreativas y productivas son permanentes y sirven como base para la realización de acciones conjuntas que propenden al desarrollo comunitario.',
                'valor' => 4,
                'indice_calificacion' => '4.2.2'
            ],
            [
                'descripcion' => 'La escuela de padres es coherente con el PEI, cuenta con el respaldo pedagógico de los docentes y se encuentra ampliamente divulgada en la comunidad. Además, su acogida entre los integrantes de la familia es significativa.',
                'valor' => 3,
                'indice_calificacion' => '4.2.1'
            ],
            [
                'descripcion' => 'La institución cuenta con algunas formas de reconocimiento de los logros de docentes y estudiantes, pero éstas no se aplican de manera organizada ni sistemática.',
                'valor' => 1,
                'indice_calificacion' => '1.4.3'
            ],
            [
                'descripcion' => 'La institución revisa periódicamente su proceso de seguimiento a los desempeños de los estudiantes y realiza los ajustes pertinentes, en el marco de la evaluación formativa.',
                'valor' => 4,
                'indice_calificacion' => '2.4.1'
            ],
            [
                'descripcion' => 'La institución revisa periódicamente la calidad y disponibilidad del archivo académico y ajusta y mejora este sistema.',
                'valor' => 4,
                'indice_calificacion' => '3.1.2'
            ],
            [
                'descripcion' => 'La institución cuenta con una
política para el establecimiento
de alianzas o acuerdos con
diferentes entidades para
apoyar la ejecución de sus proyectos.
Sin embargo, no hace seguimiento sistemático a sus resultados.',
                'valor' => 2,
                'indice_calificacion' => '1.6.3'
            ],
            [
                'descripcion' => 'Hay manual de convivencia,
pero éste pertenece solamente
a algunas sedes.',
                'valor' => 1,
                'indice_calificacion' => '1.5.5'
            ],
            [
                'descripcion' => 'Se cuenta con una formulación de la misión, la visión y los principios que articulan e identifican a la institución como un todo. Estos elementos han sido apropiados parcialmente por la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.1.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente la pertinencia y funcionalidad de los procedimientos establecidos para la dotación, uso y mantenimiento de los recursos para el aprendizaje y las ajusta en función de los nuevos requerimientos.',
                'valor' => 4,
                'indice_calificacion' => '2.1.3'
            ],
            [
                'descripcion' => 'En los procesos de adquisición
de los recursos para el aprendizaje
(computadores, laboratorios,
bibliotecas, etc.) priman
los intereses aislados de algunos
docentes o los criterios de
la administración municipal.',
                'valor' => 1,
                'indice_calificacion' => '3.2.4'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa periódicamente el impacto de las tareas escolares en los aprendizajes
de los estudiantes y ajusta su política en este tema.',
                'valor' => 4,
                'indice_calificacion' => '2.2.2'
            ],
            [
                'descripcion' => 'En algunas sedes hay algunos
acuerdos básicos entre docentes y estudiantes acerca de la intencionalidad de las tareas escolares para algunos grados, niveles o áreas.',
                'valor' => 2,
                'indice_calificacion' => '2.2.2'
            ],
            [
                'descripcion' => 'El sistema de evaluación del desempeño de los estudiantes de la institución educativa, se aplica permanentemente. Se realiza seguimiento y cuenta con un buen sistema de información, el cual se evalúa periódicamente y se ajusta de acuerdo con las necesidades de la diversidad de los estudiantes.',
                'valor' => 4,
                'indice_calificacion' => '2.3.4'
            ],
            [
                'descripcion' => 'Los estudiantes se identifican
con la institución a través de
elementos tales como las instalaciones, el escudo, el uniforme o el himno, pero también con aspectos relacionados con la filosofía y los valores institucionales.',
                'valor' => 2,
                'indice_calificacion' => '1.5.1'
            ],
            [
                'descripcion' => 'La institución lleva registros
contables de algunas actividades,
pero éstos se hacen de
forma desorganizada y sin la
totalidad de los soportes respectivos.',
                'valor' => 1,
                'indice_calificacion' => '3.5.2'
            ],
            [
                'descripcion' => 'La institución evalúa sistemáticamente la efectividad de su programa de inducción y de acogida a estudiantes nuevos y sus familias y a otro personal, y realiza los ajustes pertinentes.',
                'valor' => 4,
                'indice_calificacion' => '1.5.3'
            ],
            [
                'descripcion' => 'Las sedes poseen espacios amplios y suficientes,
y éstos se encuentran adecuadamente dotados,
organizados y decorados y señalizados, lo que
propicia un buen ambiente para el aprendizaje y
la convivencia de la diversidad de sus miembros,
incluso de aquellos que requieren adaptaciones
para su movilidad y ubicación en el espacio. Las
plantas físicas son usadas adecuadamente fuera
de la jornada escolar ordinaria.',
                'valor' => 3,
                'indice_calificacion' => '1.5.2'
            ],
            [
                'descripcion' => 'La elaboración del presupuesto
se hace teniendo en cuenta
las necesidades de las sedes y
niveles, y toma como referentes
el Plan Operativo Anual, el
PEI, el plan de mejoramiento y
la normatividad vigente.',
                'valor' => 2,
                'indice_calificacion' => '3.5.1'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa periódicamente la cobertura, calidad y oportunidad de los servicios complementarios y recursos y promueve acciones correctivas en función de las necesidades del estudiantado.',
                'valor' => 4,
                'indice_calificacion' => '3.3.1'
            ],
            [
                'descripcion' => 'La institución revisa y evalúa periódicamente su estrategia de planeación de clases, y utiliza los
resultados para implementar medidas de ajuste y mejoramiento que contribuyen a la consolidación
de conjuntos articulados y ordenados de actividades para desarrollar las competencias de los estudiantes.',
                'valor' => 4,
                'indice_calificacion' => '2.3.2'
            ],
            [
                'descripcion' => 'La planeación de clases es reconocida como
la estrategia institucional que posibilita establecer
y aplicar el conjunto ordenado y articulado
de actividades para: la consecución de un objetivo relacionado con un contenido concreto; la elección de los recursos didácticos; el establecimiento de unos procesos evaluativos; y la definición de unos estándares de referencia. Los planes de aula establecen sistemas didácticos accesibles a todo el estudiantado, que minimizan barreras al aprendizaje y están relacionados con el diseño curricular y el enfoque metodológico.',
                'valor' => 3,
                'indice_calificacion' => '2.3.2'
            ],
            [
                'descripcion' => 'Algunas sedes de la institución
tienen áreas insuficientes y poco organizadas, lo que conlleva al hacinamiento y a un sentimiento de escasa estimulación y apropiación. La dotación es precaria.',
                'valor' => 1,
                'indice_calificacion' => '1.5.2'
            ],
            [
                'descripcion' => 'La institución se interesa de forma programática
en la proyección personal y el futuro de sus estudiantes; este programa es conocido por la comunidad educativa, que lo apoya y enriquece.',
                'valor' => 3,
                'indice_calificacion' => '4.1.4'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente la coherencia y la articulación del enfoque metodológico con el PEI, el plan de mejoramiento y las prácticas
de aula de sus docentes. Esta información es usada como base para la realización de ajustes.',
                'valor' => 4,
                'indice_calificacion' => '2.1.2'
            ],
            [
                'descripcion' => 'Los programas de prevención de riesgos físicos de la institución son monitoreados y evaluados con el fin de establecer su eficacia. Con ello, se propicia su fortalecimiento de las alianzas y la
búsqueda de apoyo de otras instituciones y de la comunidad.',
                'valor' => 4,
                'indice_calificacion' => '4.4.1'
            ],
            [
                'descripcion' => 'La información académica de
los estudiantes está organizada
en archivo en algunas sedes,
según criterios diferentes.',
                'valor' => 1,
                'indice_calificacion' => '3.1.2'
            ],
            [
                'descripcion' => 'Las sedes y los niveles de la institución conocen la política de atención a la población que experimenta barreras para el aprendizaje y la participación, trabajan conjuntamente para diseñar modelos pedagógicos flexibles que permitan la inclusión y la atención a estas personas, y los dan a conocer a la comunidad.',
                'valor' => 3,
                'indice_calificacion' => '4.1.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente cuáles son las actitudes de los estudiantes hacia el aprendizaje y realiza acciones para favorecerlas.',
                'valor' => 4,
                'indice_calificacion' => '1.5.4'
            ],
            [
                'descripcion' => 'La institución ha establecido un proceso para realizar la autoevaluación, mediante instrumentos y procedimientos claros para las distintas sedes, pero éstos todavía no son utilizados integralmente.',
                'valor' => 2,
                'indice_calificacion' => '1.2.5'
            ],
            [
                'descripcion' => 'La institución cuenta con programas
para la prevención de riesgos físicos que hacen parte de los proyectos transversales y son coherentes con
el PEI.',
                'valor' => 2,
                'indice_calificacion' => '4.4.1'
            ],
            [
                'descripcion' => 'El servicio social estudiantil es valorado por la
comunidad y los estudiantes han desarrollado
una capacidad de empatía e integración con ésta en la medida en que éstos contribuyen a la solución de sus necesidades a través de
programas interesantes y debidamente organizados.',
                'valor' => 3,
                'indice_calificacion' => '4.2.4'
            ],
            [
                'descripcion' => 'La institución cuenta con un sistema de estímulos y reconocimientos a los logros de docentes y estudiantes que se aplica de manera coherente, sistemática y organizada.',
                'valor' => 2,
                'indice_calificacion' => '1.4.3'
            ],
            [
                'descripcion' => 'La institución realiza jornadas,
talleres y otras actividades
orientadas a reducir los conflictos.
Estas actividades son convocadas por algunos docentes.
No hay una conciencia clara acerca de todas las competencias requeridas para la convivencia.',
                'valor' => 1,
                'indice_calificacion' => '1.5.8'
            ],
            [
                'descripcion' => 'La institución cuenta con programas
concertados con el cuerpo docente para apoyar a los estudiantes en sus proyectos de vida. Estos programas están articulados con la identificación
de las necesidades y expectativas de los estudiantes, así como con las posibilidades que ofrece el entorno para su desarrollo.',
                'valor' => 2,
                'indice_calificacion' => '4.1.4'
            ],
            [
                'descripcion' => 'La institución revisa periódicamente los procedimientos e instrumentos establecidos para realizar la autoevaluación integral. Con esto orienta, ajusta y mejora continuamente este proceso.',
                'valor' => 4,
                'indice_calificacion' => '1.2.5'
            ],
            [
                'descripcion' => 'La institución cuenta con un
conjunto de criterios básicos
acerca de su manejo y éstos
son aplicados parcialmente
por las sedes.',
                'valor' => 2,
                'indice_calificacion' => '1.2.1'
            ],
            [
                'descripcion' => 'La institución implementa un proceso de
autoevaluación integral que abarca las diferentes
sedes, empleando instrumentos y procedimientos
claros. Además, cuenta con la participación de los diferentes estamentos de la comunidad educativa.',
                'valor' => 3,
                'indice_calificacion' => '1.3.1'
            ],
            [
                'descripcion' => 'Se evalúa periódicamente el cumplimiento de las metas, lo que permite realizar ajustes y reorientar los diferentes aspectos de la gestión institucional. La revisión periódica de las metas da cuenta del proceso progresivo de la transformación hacia la atención a la población diversa y vulnerable.',
                'valor' => 4,
                'indice_calificacion' => '1.1.2'
            ],
            [
                'descripcion' => 'Los programas de la escuela de padres se evalúan
de forma regular; hay sistematización de estos
procesos y su mejoramiento se hace teniendo en
cuenta las necesidades y expectativas de los integrantes de la familia y de la comunidad.',
                'valor' => 4,
                'indice_calificacion' => '4.2.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente la eficiencia y pertinencia de los criterios establecidos para su manejo y realiza ajustes para mejorarlos y lograr mayor cohesión. Se trabaja en equipo y se aplican distintas formas para resolver los problemas.',
                'valor' => 4,
                'indice_calificacion' => '1.2.1'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente la coherencia y la articulación del enfoque metodológico con el PEI, el plan de mejoramiento y las prácticas
de aula de sus docentes. Esta información es usada como base para la realización de ajustes.',
                'valor' => 4,
                'indice_calificacion' => '2.1.6'
            ],
            [
                'descripcion' => 'La institución establece acuerdos
ocasionales con otras entidades:
bibliotecas, puestos de salud, hospitales, granjas, casas de cultura y centros de recreación para desarrollar algunas actividades pedagógicas.',
                'valor' => 1,
                'indice_calificacion' => '1.6.3'
            ],
            [
                'descripcion' => 'La institución cuenta con una política clara sobre la intencionalidad de las tareas escolares en el afianzamiento de los aprendizajes de los estudiantes y ésta es aplicada por todos los docentes, conocida y
comprendida por los estudiantes y las familias.',
                'valor' => 3,
                'indice_calificacion' => '2.2.2'
            ],
            [
                'descripcion' => 'La institución ha identificado los principales problemas que constituyen factores de riesgo para sus estudiantes y la comunidad y diseña acciones orientadas a su prevención. Además, tiene en cuenta los análisis de los
factores de riesgo sobre su comunidad
realizados por otras entidades.',
                'valor' => 2,
                'indice_calificacion' => '4.4.2'
            ],
            [
                'descripcion' => 'La institución cuenta con lineamientos
que permiten que sus
integrantes opten por procesos
de formación en coherencia
con el PEI y con las necesidades
detectadas.',
                'valor' => 2,
                'indice_calificacion' => '3.4.3'
            ],
            [
                'descripcion' => 'La mayoría de planes, proyectos
y acciones están articulados
al planteamiento estratégico
de la institución integrada
e inclusiva y eventualmente se
trabaja en equipo para articular
las acciones.',
                'valor' => 2,
                'indice_calificacion' => '1.2.2'
            ],
            [
                'descripcion' => 'El comité de convivencia está
conformado, pero no se reúne
periódicamente para analizar
los casos que le son remitidos.',
                'valor' => 2,
                'indice_calificacion' => '1.3.4'
            ],
            [
                'descripcion' => 'La institución cuenta con una
política de evaluación de los
desempeños académicos de los
estudiantes que contempla los
elementos del plan de estudios,
los criterios de los docentes e integra la legislación vigente.',
                'valor' => 2,
                'indice_calificacion' => '2.1.5'
            ],
            [
                'descripcion' => 'La institución cuenta con el comité
de convivencia, el cual se
encarga de la identificación y
mediación de los conflictos que
se presentan entre los diferentes
estamentos de la comunidad
educativa. Además, existe
un consenso acerca de las
competencias que requieren
desarrollarse para fortalecer la
convivencia y el respeto a la diversidad,
en coherencia con el
PEI y la normatividad vigente.',
                'valor' => 2,
                'indice_calificacion' => '1.5.8'
            ],
            [
                'descripcion' => 'La institución ha definido algunas
actividades de inducción, pero éstas no se ejecutan adecuadamente o se realizan solamente en algunas sedes.',
                'valor' => 1,
                'indice_calificacion' => '1.5.3'
            ],
            [
                'descripcion' => 'El comité de convivencia está
conformado, pero sus integrantes no se reúnen ni se toman las decisiones que son de su competencia.',
                'valor' => 1,
                'indice_calificacion' => '1.3.4'
            ],
            [
                'descripcion' => 'La institución cuenta con una política y una
programación completa de actividades extracurriculares que propicia la participación de todos, y éstas se orientan a complementar la formación de los estudiantes en los aspectos sociales, artísticos, deportivos, emocionales,
éticos, etc.',
                'valor' => 3,
                'indice_calificacion' => '1.5.6'
            ],
            [
                'descripcion' => 'El impacto del servicio social estudiantil es evaluado por la institución y se tienen en cuenta tanto las necesidades y expectativas de la comunidad como su satisfacción con estos programas.',
                'valor' => 4,
                'indice_calificacion' => '4.2.4'
            ],
            [
                'descripcion' => 'La institución evalúa periódicamente la articulación de los planes, proyectos y acciones a su planteamiento estratégico, y realiza los cambios y ajustes necesarios para lograrla, mediante trabajo en equipo.',
                'valor' => 4,
                'indice_calificacion' => '1.2.2'
            ],
            [
                'descripcion' => 'La institución establece relaciones esporádicas con el sector productivo; en ocasiones se reciben aportes y donaciones,
y en otros casos cuenta con el
acceso a laboratorios, talleres
y espacios recreativos.',
                'valor' => 1,
                'indice_calificacion' => '1.6.4'
            ],

            [
                'descripcion' => 'No posee',
                'valor' => 1,
                'indice_calificacion' => '3.5.3'
            ],
            [
                'descripcion' => 'Posee pero es mínimo',
                'valor' => 2,
                'indice_calificacion' => '3.5.3'
            ],
            [
                'descripcion' => 'Posee pero es aceptable',
                'valor' => 3,
                'indice_calificacion' => '3.5.3'
            ],
            [
                'descripcion' => 'Posee y es suficiente',
                'valor' => 4,
                'indice_calificacion' => '3.5.3'
            ],
        ];
        foreach ($notasCalificaciones as $notaCalificacion) {
            NotaCalificacion::firstOrCreate(
                [
                    'valor' => $notaCalificacion['valor'],
                    'indice_calificacion' => $notaCalificacion['indice_calificacion']
                ],
                $notaCalificacion // Datos a insertar/actualizar
            );
        }
    }
}
