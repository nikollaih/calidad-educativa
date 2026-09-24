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
          "indice_calificacion"=> "1.1.1",
        "valor"=> 1,
        "descripcion"=> "Hay una formulación incipiente o parcial del direccionamiento estratégico como institución integrada e inclusiva. \nPueden estar prevaleciendo la misión, la visión o los principios de cada una de las distintas sedes."
      ],
      [
          "indice_calificacion"=> "1.1.1",
        "valor"=> 2,
        "descripcion"=> "Hay algunos avances hacia la formulación de la misión,\nla visión y los principios que orientan estratégicamente la\ninstitución integrada e inclusiva, pero éstos todavía no están totalmente articulados."
      ],
      [
          "indice_calificacion"=> "1.1.1",
        "valor"=> 3,
        "descripcion"=> "Se cuenta con una misión, visión y principios articulados que identifican la Institución Educativa como un todo. Estos componentes han sido apropiados parcialmente por la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.1.1",
        "valor"=> 4,
        "descripcion"=> "La misión, la visión y los principios están claramente definidos para la institución integrada e inclusiva, son revisados y ajustados periódicamente, en función de los nuevos retos y de las necesidades de los estudiantes. Además, son conocidos y apropiados por la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.1.2",
        "valor"=> 1,
        "descripcion"=> "Las metas están formuladas\nsolamente para algunas sedes.\nNo todas son cuantificables y\nresponden a unos propósitos\nclaros de mejoramiento."
      ],
      [
          "indice_calificacion"=> "1.1.2",
        "valor"=> 2,
        "descripcion"=> "Hay metas establecidas para\nla institución integrada e inclusiva, pero solamente algunas responden a sus objetivos y al direccionamiento estratégico."
      ],
      [
          "indice_calificacion"=> "1.1.2",
        "valor"=> 3,
        "descripcion"=> "Todas las metas establecidas para la institución integrada e inclusiva responden a sus objetivos y al direccionamiento estratégico. Además, éstas son conocidas y puestas en práctica por la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.1.2",
        "valor"=> 4,
        "descripcion"=> "Se evalúa periódicamente el cumplimiento de las metas, lo que permite realizar ajustes y reorientar los diferentes aspectos de la gestión institucional. La revisión periódica de las metas da cuenta del proceso progresivo de la transformación hacia la atención a la población diversa y vulnerable."
      ],
      [
          "indice_calificacion"=> "1.1.3",
        "valor"=> 1,
        "descripcion"=> "Los procesos de inclusión de personas de diferentes grupos poblacionales o diversidad\ncultural están bajo la responsabilidad de cada sede; no responden a una estrategia institucional articulada y conocida por todos los estamentos de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.1.3",
        "valor"=> 2,
        "descripcion"=> "La institución tiene una estrategia articulada para promover inclusión de personas de\ndiferentes grupos poblacionales o diversidad cultural, que es conocida por todos los\nestamentos de la comunidad educativa para direccionar las acciones en este sentido."
      ],
      [
          "indice_calificacion"=> "1.1.3",
        "valor"=> 3,
        "descripcion"=> "La Institución Educativa cuenta con una política de promoción de la inclusión de personas de diferentes grupos poblacionales o diversidad cultural como referente para que se adapten metodologías y espacios físicos,\napoyar talentos y hacerlos valorar por todos los estamentos de la comunidad educativa.\nAdemás, promueve la coordinación entre organismos para su atención integral."
      ],
      [
          "indice_calificacion"=> "1.1.3",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente su política de inclusión de personas de diferentes grupos poblacionales o diversidad cultural, e introduce los ajustes pertinentes para fortalecerla."
      ],
      [
          "indice_calificacion"=> "1.2.1",
        "valor"=> 1,
        "descripcion"=> "Los criterios básicos acerca del manejo de la institución integrada no están claramente definidos. Por ello hay dificultades en la coordinación entre las sedes y problemas en la delegación de tareas. Se trabaja aisladamente y no siempre se llevan a término los propósitos planteados, evidenciando falta de trabajo en equipo."
      ],
      [
          "indice_calificacion"=> "1.2.1",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un conjunto de criterios básicos acerca de su manejo y trabajo en equipo pero éstos son aplicados parcialmente."
      ],
      [
          "indice_calificacion"=> "1.2.1",
        "valor"=> 3,
        "descripcion"=> "Los criterios básicos sobre el manejo del establecimiento educativo y la atención a la diversidad fueron definidos de manera participativa y permiten el trabajo en equipo garantizando la ejecución de los diferentes proyectos institucionales, pero no han sido evaluados para establecer su eficacia."
      ],
      [
          "indice_calificacion"=> "1.2.1",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente la eficiencia y pertinencia de los criterios establecidos para su manejo y realiza ajustes para mejorarlos y lograr mayor cohesión. Se trabaja en equipo y se aplican distintas formas para resolver los problemas."
      ],
      [
          "indice_calificacion"=> "1.2.2",
        "valor"=> 1,
        "descripcion"=> "Los planes y proyectos se elaboran y se implementan de manera aislada y no responden con objetividad al planteamiento estratégico. \nLa articulación de los mismos en las diferentes sedes es inexistente o incipiente."
      ],
      [
          "indice_calificacion"=> "1.2.2",
        "valor"=> 2,
        "descripcion"=> "Algunos planes y  proyectos están articulados\nal planteamiento estratégico de la institución integrada\ne inclusiva."
      ],
      [
          "indice_calificacion"=> "1.2.2",
        "valor"=> 3,
        "descripcion"=> "Los planes, proyectos y acciones se enmarcan en principios de corresponsabilidad, participación\ny equidad, articulados al planteamiento estratégico de la institución integrada e inclusiva,\ny son conocidos por la comunidad educativa. Se trabaja en equipo para articular las acciones."
      ],
      [
          "indice_calificacion"=> "1.2.2",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente la articulación de los planes y proyectos a su planteamiento estratégico, y realiza los cambios y ajustes necesarios para lograrla, mediante trabajo en equipo."
      ],
      [
          "indice_calificacion"=> "1.2.3",
        "valor"=> 1,
        "descripcion"=> "La institución realiza su autoevaluación\nsin un procedimiento claramente establecido;\nla recolección de información y la evaluación se hacen sobre la marcha. Además, cada sede tiene su propio proceso de evaluación."
      ],
      [
          "indice_calificacion"=> "1.2.3",
        "valor"=> 2,
        "descripcion"=> "La institución ha establecido un proceso para realizar la autoevaluación, mediante instrumentos y procedimientos claros para las distintas sedes, pero éstos todavía no son utilizados integralmente."
      ],
      [
          "indice_calificacion"=> "1.2.3",
        "valor"=> 3,
        "descripcion"=> "La institución implementa un proceso de autoevaluación integral a partir de los resultados de las evaluaciones internas, externas, evaluaciones de desempeño de los docentes y personal administrativo, que abarca las diferentes sedes empleando instrumentos y procedimientos claros. Además, cuenta con la participación de los diferentes estamentos de la comunidad educativa cuyo resultados se evidencia en el plan de mejoramiento institucional y la resignificación del PEI."
      ],
      [
          "indice_calificacion"=> "1.2.3",
        "valor"=> 4,
        "descripcion"=> "La institución revisa periódicamente los procedimientos e instrumentos establecidos para realizar la autoevaluación integral y aplicar procesos de mejora continua."
      ],
      [
          "indice_calificacion"=> "1.3.1",
        "valor"=> 1,
        "descripcion"=> "La institución no ha conformado el consejo directivo como instancia de participación y toma de decisiones."
      ],
      [
          "indice_calificacion"=> "1.3.1",
        "valor"=> 2,
        "descripcion"=> "\nLa institución cuenta con un consejo directivo; sin embargo, no existe un plan de trabajo definido para orientar los procesos de planeación y el seguimiento a las acciones institucionales."
      ],
      [
          "indice_calificacion"=> "1.3.1",
        "valor"=> 3,
        "descripcion"=> "El consejo directivo tiene una agenda y un cronograma de trabajo para orientar los procesos de planeación y el seguimiento a las acciones institucionales. Sin embargo, no se reúne con regularidad."
      ],
      [
          "indice_calificacion"=> "1.3.1",
        "valor"=> 4,
        "descripcion"=> "\n\nEl consejo directivo se reúne periódicamente de acuerdo con un cronograma establecido y sesiona con el aporte activo de todos sus miembros. Hace seguimiento sistemático al plan de trabajo, para garantizar su cumplimiento."
      ],
      [
          "indice_calificacion"=> "1.3.2",
        "valor"=> 1,
        "descripcion"=> "El consejo académico está conformado pero tiene escasa\nincidencia en el diseño e implementación del componente pedagógico. Además, no cuenta con un plan de trabajo y cronograma de reuniones."
      ],
      [
          "indice_calificacion"=> "1.3.2",
        "valor"=> 2,
        "descripcion"=> "\nEl consejo académico está conformado en el marco de la integración institucional, y cuenta con una metodología de trabajo orientada al diseño y la implementación del componente pedagógico. Sin embargo, no se reúne con regularidad o no asisten todos sus miembros, afectando negativamente la toma de decisiones."
      ],
      [
          "indice_calificacion"=> "1.3.2",
        "valor"=> 3,
        "descripcion"=> "El consejo académico se reúne periódicamente para garantizar que el componente pedagógico sea coherente con las necesidades de la diversidad y se implemente en todas las sedes, áreas y niveles. Sin embargo, no hace seguimiento suficiente al mismo."
      ],
      [
          "indice_calificacion"=> "1.3.2",
        "valor"=> 4,
        "descripcion"=> "El consejo académico se reúne ordinariamente y cuenta con el aporte activo de todos sus miembros. Allí se toman decisiones sobre los procesos pedagógicos y se hace seguimiento sistemático al plan de trabajo, para asegurar su cumplimiento."
      ],
      [
          "indice_calificacion"=> "1.3.3",
        "valor"=> 1,
        "descripcion"=> "El comité de convivencia no está conformado."
      ],
      [
          "indice_calificacion"=> "1.3.3",
        "valor"=> 2,
        "descripcion"=> "El comité de convivencia está conformado, pero sus integrantes no se reúnen ni se toman las decisiones que son de su competencia."
      ],
      [
          "indice_calificacion"=> "1.3.3",
        "valor"=> 3,
        "descripcion"=> "El comité de convivencia se reúne periódicamente y es reconocido como la instancia encargada de analizar y plantear soluciones a los problemas de convivencia que se presentan en la institución."
      ],
      [
          "indice_calificacion"=> "1.3.3",
        "valor"=> 4,
        "descripcion"=> "El comité de convivencia se reúne periódicamente y cuenta con el aporte activo de todos sus miembros. Además, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo."
      ],
      [
          "indice_calificacion"=> "1.3.4",
        "valor"=> 1,
        "descripcion"=> "La institución no cuenta con un consejo estudiantil conformado mediante elección democrática."
      ],
      [
          "indice_calificacion"=> "1.3.4",
        "valor"=> 2,
        "descripcion"=> "El consejo estudiantil está conformado\nmediante elección democrática, pero no se reúne periódicamente para deliberar y tomar las decisiones que le corresponden."
      ],
      [
          "indice_calificacion"=> "1.3.4",
        "valor"=> 3,
        "descripcion"=> "El consejo estudiantil se reúne periódicamente y es reconocido como la instancia de representación de los intereses de todos y todas los estudiantes de la institución."
      ],
      [
          "indice_calificacion"=> "1.3.4",
        "valor"=> 4,
        "descripcion"=> "El consejo estudiantil se reúne periódicamente y cuenta con el aporte activo de todos sus miembros.\nAdemás, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo."
      ],
      [
          "indice_calificacion"=> "1.3.5",
        "valor"=> 1,
        "descripcion"=> "La institución no cuenta con un personero elegido democráticamente."
      ],
      [
          "indice_calificacion"=> "1.3.5",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un personero elegido democráticamente\nque representa a todas y todos los estudiantes de todas las sedes, pero no es tenido en cuenta en las decisiones."
      ],
      [
          "indice_calificacion"=> "1.3.5",
        "valor"=> 3,
        "descripcion"=> "El personero elegido desarrolla proyectos y programas a favor de todas y todos los estudiantes\ny su labor es reconocida en los diferentes estamentos de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.3.5",
        "valor"=> 4,
        "descripcion"=> "El gobierno escolar evalúa el impacto de la labor del personero y a partir de ésta se mejoran los procesos de elección y participación del estudiantado."
      ],
      [
          "indice_calificacion"=> "1.3.6",
        "valor"=> 1,
        "descripcion"=> "No se reconoce la asamblea de padres de familia como instancia de participación para la toma de decisiones."
      ],
      [
          "indice_calificacion"=> "1.3.6",
        "valor"=> 2,
        "descripcion"=> "Está conformada la asamblea de padres de familia, pero ésta\nno se reúne periódicamente para deliberar y tomar decisiones\nsobre los temas de su competencia."
      ],
      [
          "indice_calificacion"=> "1.3.6",
        "valor"=> 3,
        "descripcion"=> "La asamblea de padres de familia se reúne periódicamente y es reconocida por la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.3.6",
        "valor"=> 4,
        "descripcion"=> "La asamblea de padres de familia se reúne periódicamente y cuenta con la participación activa de sus integrantes. Además, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo."
      ],
      [
          "indice_calificacion"=> "1.3.7",
        "valor"=> 1,
        "descripcion"=> "La institución no cuenta con un consejo de padres de familia debidamente conformado."
      ],
      [
          "indice_calificacion"=> "1.3.7",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un consejo de padres de familia el cual se reúne esporádicamente para tratar asuntos de su competencia."
      ],
      [
          "indice_calificacion"=> "1.3.7",
        "valor"=> 3,
        "descripcion"=> "El consejo de padres de familia se reúne periódicamente para apoyar al rector o director en el marco del plan de mejoramiento.  Sin embargo, no hace seguimiento sistemático a los resultados obtenidos."
      ],
      [
          "indice_calificacion"=> "1.3.7",
        "valor"=> 4,
        "descripcion"=> "El consejo de padres de familia se reúne periódicamente y cuenta con la participación activa de todos sus miembros. Además, evalúa los resultados de sus acciones y decisiones y los utiliza para fortalecer su trabajo."
      ],
      [
          "indice_calificacion"=> "1.4.1",
        "valor"=> 1,
        "descripcion"=> "La institución cuenta con algunos mecanismos de comunicación que utiliza ocasionalmente para difundir información entre los integrantes de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.4.1",
        "valor"=> 2,
        "descripcion"=> "La institución ha definido los mecanismos de comunicación de acuerdo con las características y el tipo de información pertinente para cada uno de los estamentos de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.4.1",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con una política de comunicación institucional para informar y actualizar a cada uno de los estamentos de la comunidad educativa, pero no se evalúa."
      ],
      [
          "indice_calificacion"=> "1.4.1",
        "valor"=> 4,
        "descripcion"=> "La política de comunicación institucional es reconocida y aplicada por todos los integrantes de la comunidad educativa; cuenta con principios de objetividad, transparencia y celeridad, y se evalúa periódicamente."
      ],
      [
          "indice_calificacion"=> "1.4.2",
        "valor"=> 1,
        "descripcion"=> "La institución realiza esporádicamente actividades orientadas a la integración, al bienestar y al reconocimiento de los logros de docentes, estudiantes, padres de familia y personal administrativo, pero estas no se aplican de manera organizada ni sistemática."
      ],
      [
          "indice_calificacion"=> "1.4.2",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un programa de bienestar que se ejecuta parcialmente, además, no tiene en cuenta a todos los estamentos de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.4.2",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con un programa de bienestar que integra un sistema de estímulos y reconocimiento de logros para docentes, estudiantes, padres de familia y personal administrativo, el cual se cumple en su totalidad y se aplica de manera coherente, sistemática y organizada."
      ],
      [
          "indice_calificacion"=> "1.4.2",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y evalúa continuamente su programa de bienestar para docentes, estudiantes, padres de familia y personal administrativo y realiza los ajustes pertinentes. "
      ],
      [
          "indice_calificacion"=> "1.4.3",
        "valor"=> 1,
        "descripcion"=> "La institución educativa no cuenta con criterios claros para el apoyo a la investigación e identificación de buenas prácticas pedagógicas, administrativas y culturales."
      ],
      [
          "indice_calificacion"=> "1.4.3",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un programa para el apoyo a la investigación e identificación de buenas prácticas pedagógicas, administrativas y culturales, el cual se ha implementado parcialmente."
      ],
      [
          "indice_calificacion"=> "1.4.3",
        "valor"=> 3,
        "descripcion"=> "La institución ha implementado el programa para el apoyo a la investigación e identificación de buenas prácticas pedagógicas, administrativas y culturales, el cual reconoce la diversidad de la población y propicia el intercambio de experiencias."
      ],
      [
          "indice_calificacion"=> "1.4.3",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódica y sistemáticamente el impacto de la socialización, la documentación, la apropiación y ejecución del programa para el apoyo a la investigación e identificación de buenas prácticas pedagógicas, administrativas y culturales; y realiza los ajustes pertinentes."
      ],
      [
          "indice_calificacion"=> "1.5.1",
        "valor"=> 1,
        "descripcion"=> "Los estudiantes, docentes, padres de familia y administrativos se sienten parte de la institución educativa y se identifican con algunos elementos simbólicos de la institución."
      ],
      [
          "indice_calificacion"=> "1.5.1",
        "valor"=> 2,
        "descripcion"=> "Los estudiantes, docentes, padres de familia y administrativos se sienten parte de la institución educativa, se identifican con algunos elementos simbólicos y con aspectos relacionados con el horizonte institucional. "
      ],
      [
          "indice_calificacion"=> "1.5.1",
        "valor"=> 3,
        "descripcion"=> "Los estudiantes, docentes, padres de familia y administrativos se identifican y sienten orgullo de pertenecer a la institución lo cual se evidencia en la aplicación de los instrumentos valorativos y actitudinales, así como en la participación y representación activa en eventos internos y externos. "
      ],
      [
          "indice_calificacion"=> "1.5.1",
        "valor"=> 4,
        "descripcion"=> "Se consolidan y analizan periódicamente los instrumentos valorativos y actitudinales que evidencian el grado de pertenencia de los estudiantes, docentes, padres de familia y administrativos hacia la institución y se establecen medidas oportunas para su promoción y fortalecimiento."
      ],
      [
          "indice_calificacion"=> "1.5.2",
        "valor"=> 1,
        "descripcion"=> "La institución realiza algunas actividades de inducción con estudiantes, docentes, administrativos y padres de familia, pero éstas no son sistemáticas y obedecen a iniciativas individuales, de áreas o de sedes."
      ],
      [
          "indice_calificacion"=> "1.5.2",
        "valor"=> 2,
        "descripcion"=> "Al inicio del año escolar, se realizan actividades de inducción con estudiantes, docentes, administrativos y padres de familia, pero estas no responden a un programa institucional."
      ],
      [
          "indice_calificacion"=> "1.5.2",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con un programa estructurado de inducción y reinducción, con estrategias que se adaptan a las condiciones personales, sociales y culturales de todos sus integrantes, el cual es socializado al inicio del año escolar."
      ],
      [
          "indice_calificacion"=> "1.5.2",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa sistemáticamente la efectividad de su programa de inducción y reinducción y realiza los ajustes pertinentes para el mejoramiento continuo."
      ],
      [
          "indice_calificacion"=> "1.5.3",
        "valor"=> 1,
        "descripcion"=> "Existe un manual de convivencia, pero su aplicación está restringida a algunas sedes y no es reconocido como herramienta para orientar la vida escolar."
      ],
      [
          "indice_calificacion"=> "1.5.3",
        "valor"=> 2,
        "descripcion"=> "El manual de convivencia es conocido por la mayoría de los miembros de la comunidad educativa y se utiliza para regular la convivencia y promover valores compartidos."
      ],
      [
          "indice_calificacion"=> "1.5.3",
        "valor"=> 3,
        "descripcion"=> "El manual de convivencia se emplea de manera activa como instrumento que orienta valores, principios, normas y procedimientos para fomentar una convivencia armónica y el respeto por la diversidad."
      ],
      [
          "indice_calificacion"=> "1.5.3",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y evalúa periódicamente el manual de convivencia, lo ajusta en función de su impacto en el clima escolar y lo articula con los procesos de formación ciudadana y resolución pacífica de conflictos."
      ],
      [
          "indice_calificacion"=> "1.5.4",
        "valor"=> 1,
        "descripcion"=> "Algunas sedes desarrollan actividades extracurriculares de forma aislada, sin un programa institucional que oriente su propósito ni su articulación con los procesos formativos."
      ],
      [
          "indice_calificacion"=> "1.5.4",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un programa institucional para las actividades extracurriculares, pero su implementación es parcial y no involucra a toda la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.5.4",
        "valor"=> 3,
        "descripcion"=> "Existe un programa institucional de actividades extracurriculares, orientado al fortalecimiento de las capacidades artísticas, deportivas, sociales, emocionales y éticas de los estudiantes."
      ],
      [
          "indice_calificacion"=> "1.5.4",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa regularmente su programa de actividades extracurriculares, realiza ajustes para mejorar su alcance y asegura la participación activa de todos los estudiantes."
      ],
      [
          "indice_calificacion"=> "1.5.5",
        "valor"=> 1,
        "descripcion"=> "La atención de casos difíciles y la prevención de conflictos se realiza mediante acciones aisladas por parte de los docentes, sin consolidarse todavía en una estrategia institucional alineada con el comité de convivencia."
      ],
      [
          "indice_calificacion"=> "1.5.5",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con una estrategia para abordar los casos difíciles y la prevención de conflictos pero esta no se encuentra articulada con el comité de convivencia."
      ],
      [
          "indice_calificacion"=> "1.5.5",
        "valor"=> 3,
        "descripcion"=> "La comunidad educativa reconoce el comité de convivencia como instancia para identificar y prevenir los conflictos y casos difíciles. Se implementan mecanismos internos y externos para prevenir riesgos y manejar situaciones complejas, con participación de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.5.5",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente la eficacia del comité de convivencia y de las estrategias implementadas para el manejo de conflictos y casos difíciles. Ajusta sus acciones con base en experiencias exitosas, promoviendo su apropiación por todos los estamentos."
      ],
      [
          "indice_calificacion"=> "1.6.1",
        "valor"=> 1,
        "descripcion"=> "La institución establece comunicaciones con las familias o acudientes en función de las demandas y necesidades presentadas. De manera general, cada sede posee sus propios canales de comunicación."
      ],
      [
          "indice_calificacion"=> "1.6.1",
        "valor"=> 2,
        "descripcion"=> "La institución ha definido una política de comunicación e interacción con las familias o acudientes, estableciendo canales, tipos de información y periodicidad, aunque su aplicación es parcial."
      ],
      [
          "indice_calificacion"=> "1.6.1",
        "valor"=> 3,
        "descripcion"=> "Existe un intercambio fluido de información con las familias o acudientes, en coherencia con la política institucional. Este intercambio facilita la atención oportuna a situaciones y fortalece la corresponsabilidad educativa."
      ],
      [
          "indice_calificacion"=> "1.6.1",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y evalúa sistemáticamente su política de comunicación con las familias o acudientes. Con base en los resultados, realiza los ajustes necesarios para fortalecer el vínculo y la participación activa de las familias."
      ],
      [
          "indice_calificacion"=> "1.6.2",
        "valor"=> 1,
        "descripcion"=> "La institución mantiene un contacto esporádico con sus egresados, sin un programdo establecido, ni canales sistemáticos de comunicación."
      ],
      [
          "indice_calificacion"=> "1.6.2",
        "valor"=> 2,
        "descripcion"=> "Se ha formulado un programa institucional para establecer relaciones con los egresados, definiendo canales de comunicación e instancias de participación, aunque su implementación aún es limitada."
      ],
      [
          "indice_calificacion"=> "1.6.2",
        "valor"=> 3,
        "descripcion"=> "A través del programa institucional de egresados, se realiza seguimiento de manera regular, y se utilizan indicadores para orientar sus acciones pedagógicas. Además, promueve su participación y organización, y cuenta con una base de datos que le permite tener información actualizada de los egresados (estudios postsecundarios y/o vinculación al mercado laboral, entre otros)."
      ],
      [
          "indice_calificacion"=> "1.6.2",
        "valor"=> 4,
        "descripcion"=> "El programa de relación con los egresados es evaluada periódicamente. Sus resultados orientan acciones para fortalecer el sentido de pertenencia, fomentar la participación activa y aprovechar el aporte de los mismos al mejoramiento institucional."
      ],
      [
          "indice_calificacion"=> "1.6.3",
        "valor"=> 1,
        "descripcion"=> "La institución establece acuerdos ocasionales con otras entidades del entorno (bibliotecas, centros culturales, de salud, recreación, entre otros), los cuales no responden a una estrategia articulada."
      ],
      [
          "indice_calificacion"=> "1.6.3",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con alianzas y/o acuerdos con diferentes entidades para la ejecución de sus proyectos. Sin embargo, no hace seguimiento sistemático a sus resultados."
      ],
      [
          "indice_calificacion"=> "1.6.3",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con alianzas y/o acuerdos con diferentes entidades para la ejecución de sus proyectos, con la participación de los diferentes estamentos de la comunidad educativa y sectores de la comunidad general."
      ],
      [
          "indice_calificacion"=> "1.6.3",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente el impacto de sus alianzas y/o acuerdos con entidades externas, y realiza los ajustes pertinentes en función de los resultados obtenidos, fortaleciendo el trabajo colaborativo y los beneficios para la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "1.6.4",
        "valor"=> 1,
        "descripcion"=> "Las relaciones con el sector productivo son esporádicas y se limitan a aportes puntuales, como el préstamo de espacios o la entrega de donaciones, sin un enfoque articulado con los procesos formativos."
      ],
      [
          "indice_calificacion"=> "1.6.4",
        "valor"=> 2,
        "descripcion"=> "La institución ha establecido alianzas con el sector productivo, con objetivos y metodologías definidas, aunque los sistemas de seguimiento y evaluación no están plenamente implementados."
      ],
      [
          "indice_calificacion"=> "1.6.4",
        "valor"=> 3,
        "descripcion"=> "Las alianzas con el sector productivo tienen objetivos y metodologías claras orientadas al fortalecimiento de las competencias de los estudiantes. Se realizan procesos periódicos de seguimiento y evaluación."
      ],
      [
          "indice_calificacion"=> "1.6.4",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa sistemáticamente el impacto de las alianzas con el sector productivo en el desarrollo de competencias de los estudiantes, y toma decisiones de mejora con base en los resultados obtenidos."
      ],
      [
          "indice_calificacion"=> "2.1.1",
        "valor"=> 1,
        "descripcion"=> "El plan de estudios está formulado parcialmente y no responde a las necesidades del contexto ni a lo estipulado en el PEI."
      ],
      [
          "indice_calificacion"=> "2.1.1",
        "valor"=> 2,
        "descripcion"=> "El plan de estudios responde a los lineamientos y refrentes conceptuales del orden nacional, contempla parcialmente las necesidades del contexto, aunque su implementación aún presenta inconsistencias."
      ],
      [
          "indice_calificacion"=> "2.1.1",
        "valor"=> 3,
        "descripcion"=> "El plan de estudios está estructurado de forma coherente con el PEI y el contexto institucional, promueve la inclusión y fortalece el desarrollo de competencias para la vida; se aplica de manera articulada en todas las sedes y niveles."
      ],
      [
          "indice_calificacion"=> "2.1.1",
        "valor"=> 4,
        "descripcion"=> "El plan de estudios es revisado, evaluado y ajustado periódicamente en función de los resultados académicos, las necesidades del entorno y los referentes de orden nacional."
      ],
      [
          "indice_calificacion"=> "2.1.2",
        "valor"=> 1,
        "descripcion"=> "Las prácticas pedagógicas carecen de un enfoque metodológico común y se desarrollan de forma dispersa según criterios individuales de los docentes."
      ],
      [
          "indice_calificacion"=> "2.1.2",
        "valor"=> 2,
        "descripcion"=> "Existe un enfoque metodológico definido institucionalmente, aunque su apropiación e implementación es parcial entre los docentes."
      ],
      [
          "indice_calificacion"=> "2.1.2",
        "valor"=> 3,
        "descripcion"=> "El enfoque metodológico institucional está orientado al aprendizaje activo, colaborativo, significativo e inclusivo, y se aplica de manera articulada en los distintos niveles y sedes."
      ],
      [
          "indice_calificacion"=> "2.1.2",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa sistemáticamente el enfoque metodológico, lo ajusta según los resultados y promueve su apropiación a través de procesos de formación docente."
      ],
      [
          "indice_calificacion"=> "2.1.3",
        "valor"=> 1,
        "descripcion"=> "No se cuenta con una estrategia pedagógica institucional claramente definida en el Proyecto Educativo Institucional, lo que dificulta la coherencia entre los procesos de enseñanza y aprendizaje.\n"
      ],
      [
          "indice_calificacion"=> "2.1.3",
        "valor"=> 2,
        "descripcion"=> "La institución ha definido una estrategia pedagógica en el PEI, coherente con la misión, la visión y los principios institucionales, pero ésta todavía no es aplicada de manera articulada en las diferentes sedes, niveles y grados.\n"
      ],
      [
          "indice_calificacion"=> "2.1.3",
        "valor"=> 3,
        "descripcion"=> "La institución ha definido una estrategia pedagógica en coherencia con el PEI, que propicia procesos de enseñanza centrados en el desarrollo de competencias y la atención a la diversidad, la cual se aplica de manera articulada en las diferentes sedes, niveles y grados."
      ],
      [
          "indice_calificacion"=> "2.1.3",
        "valor"=> 4,
        "descripcion"=> "La estrategia pedagógica es objeto de seguimiento, evaluación y ajuste periódico, con base en resultados de aprendizaje(pruebas internas y externas) y en el análisis de las prácticas pedagógicas.\n"
      ],
      [
          "indice_calificacion"=> "2.1.4",
        "valor"=> 1,
        "descripcion"=> "La institución no ha establecido una ruta de seguimiento y control a las horas efectivas de clase recibidas por los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.1.4",
        "valor"=> 2,
        "descripcion"=> "La institución ha establecido una ruta de seguimiento y control a las horas efectivas de clase recibidas por los estudiantes, pero no se aplica de manera sistemática y articulada para responder a las necesidades pedagógicas y garantizar el aprendizaje efectivo."
      ],
      [
          "indice_calificacion"=> "2.1.4",
        "valor"=> 3,
        "descripcion"=> "La ruta de seguimiento y control a las horas efectivas de clase recibidas por los estudiantes, hacen parte de un sistema de mejoramiento institucional que se implementa en todas las sedes y es aplicado por los docentes."
      ],
      [
          "indice_calificacion"=> "2.1.4",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente el cumplimiento de la ruta establecida para el seguimiento a las horas efectivas de clase recibidas por los estudiantes y realiza los ajustes pertinentes para mejorar el uso del tiempo pedagógico y la calidad de los procesos formativos."
      ],
      [
          "indice_calificacion"=> "2.1.5",
        "valor"=> 1,
        "descripcion"=> "La institución cuenta con un SIEE formulado, pero su aplicación es limitada y no siempre orienta adecuadamente los procesos de evaluación del aprendizaje."
      ],
      [
          "indice_calificacion"=> "2.1.5",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un Sistema Institucional de Evaluación de los Estudiantes que ha sido socializado a la comunidad educativa; se aplica parcialmente y algunos docentes lo integran en sus prácticas de aula."
      ],
      [
          "indice_calificacion"=> "2.1.5",
        "valor"=> 3,
        "descripcion"=> "El SIEE se aplica de forma coherente y sistemática, a través del cual se orientan los procesos de evaluación formativa del aprendizaje de los estudiantes, la promoción escolar y el mejoramiento institucional, en atención a la normatividad vigente. "
      ],
      [
          "indice_calificacion"=> "2.1.5",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y evalúa periódicamente la implementación del SIEE, realizando ajustes en función del desarrollo de competencias básicas y socioemocionales de los estudiantes. "
      ],
      [
          "indice_calificacion"=> "2.2.1",
        "valor"=> 1,
        "descripcion"=> "La asignación de tareas escolares no responde a criterios institucionales definidos y varía según las prácticas individuales de cada docente."
      ],
      [
          "indice_calificacion"=> "2.2.1",
        "valor"=> 2,
        "descripcion"=> "Existen orientaciones institucionales para la funcionalidad pedagógica de las tareas escolares, pero su aplicación es parcial y no siempre está articulada con los planes de aula de cada docente."
      ],
      [
          "indice_calificacion"=> "2.2.1",
        "valor"=> 3,
        "descripcion"=> "La institución implementa estrategias claras y objetivas sobre la funcionalidad pedagógica de las tareas escolares, con el propósito de fortalecer los aprendizajes de los estudiantes y son aplicadas por todos los docentes; estas se encuentran definidas en el SIEE. "
      ],
      [
          "indice_calificacion"=> "2.2.1",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y evalúa periódicamente la funcionalidad de las estrategias para las tareas escolares y su impacto en los aprendizajes de los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.2.2",
        "valor"=> 1,
        "descripcion"=> "La institución cuenta con una estrategia para el uso del tiempo destinado a los aprendizajes, pero ésta no se encuentra articulada con la planeación pedagógica. La organización y división del tiempo es deficiente, lo que se traduce en frecuentes improvisaciones."
      ],
      [
          "indice_calificacion"=> "2.2.2",
        "valor"=> 2,
        "descripcion"=> "Existe una estrategia institucional sobre el uso del tiempo para los aprendizajes, que se aplica parcialmente en algunas sedes, grados o niveles, sin garantizar su implementación integral ni coherencia en toda la institución."
      ],
      [
          "indice_calificacion"=> "2.2.2",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con estrategia para el uso apropiado de los tiempos destinados a los aprendizajes, articulada con la planeación pedagógica, la cual es implementada de manera flexible de acuerdo con las características y necesidades de los estudiantes. No obstante, hay pocas oportunidades para complementarlo con actividades extracurriculares y de refuerzo.\n"
      ],
      [
          "indice_calificacion"=> "2.2.2",
        "valor"=> 4,
        "descripcion"=> "La estrategia de distribución del tiempo curricular y extracurricular es apropiada y se utiliza efectivamente. Además, es revisada y evaluada periódicamente; se ajusta con base en los resultados académicos, a las necesidades identificadas, garantizando el máximo aprovechamiento del tiempo escolar."
      ],
      [
          "indice_calificacion"=> "2.2.3",
        "valor"=> 1,
        "descripcion"=> "Las opciones didácticas son implementadas de manera individual y aislada por los docentes, sin una articulación clara con el enfoque metodológico institucional."
      ],
      [
          "indice_calificacion"=> "2.2.3",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un enfoque metodológico que orienta las opciones didácticas empleadas por los docentes en las distintas áreas, asignaturas y proyectos transversales. No obstante, su apropiación es parcial y su aplicación no siempre es coherente entre las diferentes sedes o niveles educativos."
      ],
      [
          "indice_calificacion"=> "2.2.3",
        "valor"=> 3,
        "descripcion"=> "Las prácticas pedagógicas de los docentes se fundamentan en opciones didácticas comunes y diferenciadas, apropiadas para cada grupo poblacional, en concordancia con el plan de estudios y las características del contexto. Estas opciones son conocidas, compartidas y valoradas por la comunidad educativa.\n"
      ],
      [
          "indice_calificacion"=> "2.2.3",
        "valor"=> 4,
        "descripcion"=> "\nLa institución evalúa de forma periódica la pertinencia, coherencia y articulación de las opciones didácticas con el enfoque metodológico, las prácticas pedagógicas y el plan de estudios. Los resultados de esta evaluación son utilizados para diseñar e implementar estrategias de mejoramiento continuo."
      ],
      [
          "indice_calificacion"=> "2.3.1",
        "valor"=> 1,
        "descripcion"=> "Los ambientes de aprendizaje presentan limitaciones físicas, pedagógicas, tecnológicas y de comunicación que afectan el proceso educativo, privilegiando una comunicación vertical con el docente."
      ],
      [
          "indice_calificacion"=> "2.3.1",
        "valor"=> 2,
        "descripcion"=> "Se han realizado adecuaciones en algunos ambientes de aprendizaje, aunque aún no responden de manera integral a las necesidades pedagógicas y de inclusión. Los docentes realizan esfuerzos coordinados para mejorar la comunicación recíproca, las relaciones horizontales y la negociación con los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.3.1",
        "valor"=> 3,
        "descripcion"=> "Los ambientes de aprendizaje se diseñan y organizan para favorecer el proceso de enseñanza-aprendizaje, promover la participación, el trabajo colaborativo y atender a la diversidad, a partir de la comunicación, el vínculo afectivo y la valoración de las diferencias entre los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.3.1",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa continuamente sus ambientes de aprendizaje y las relaciones de aula, con el fin de optimizar su funcionalidad, accesibilidad, pertinencia pedagógica y una comunicación horizontal."
      ],
      [
          "indice_calificacion"=> "2.3.2",
        "valor"=> 1,
        "descripcion"=> "La motivación de los estudiantes hacia el aprendizaje depende de iniciativas individuales de algunos docentes, sin estrategias institucionales definidas."
      ],
      [
          "indice_calificacion"=> "2.3.2",
        "valor"=> 2,
        "descripcion"=> "La institución dispone de estrategias orientadas a fomentar la motivación hacia el aprendizaje en los estudiantes, aunque su implementación aún es parcial."
      ],
      [
          "indice_calificacion"=> "2.3.2",
        "valor"=> 3,
        "descripcion"=> "La institución desarrolla e implementa estrategias para fomentar el interés, la curiosidad y el compromiso de los estudiantes con su aprendizaje."
      ],
      [
          "indice_calificacion"=> "2.3.2",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente las estrategias de motivación hacia el aprendizaje y realiza ajustes para mejorar el desempeño, la permanencia y el bienestar de los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.3.3",
        "valor"=> 1,
        "descripcion"=> "Los docentes cuentan con una herramienta de planeación de carácter general; sin embargo, no está articulada con el enfoque metodológico institucional ni cuenta con los referentes conceptuales establecidos por el Ministerio de Educación Nacional."
      ],
      [
          "indice_calificacion"=> "2.3.3",
        "valor"=> 2,
        "descripcion"=> "Los planes de aula que desarrollan\nel plan de estudio presentan una secuencia didáctica articulada con la estrategia pedagócia y el enfoque metodólogico institucional. Sin embargo, éstos no son aplicados por todos los docentes en todas las sedes y niveles educativos."
      ],
      [
          "indice_calificacion"=> "2.3.3",
        "valor"=> 3,
        "descripcion"=> "Los planes de aula, que desarrollan el plan de estudio, presentan una secuencia didáctica articulada con la estrategia pedagógica y el enfoque metodológico institucional, los cuales son accesibles para todo el estudiantado y contribuyen a minimizar las barreras al aprendizaje."
      ],
      [
          "indice_calificacion"=> "2.3.3",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y evalúa periódicamente su estrategia de planeación de clases, y utiliza los\nresultados para implementar medidas de ajuste y mejoramiento que contribuyen a la consolidación\nde conjuntos articulados y ordenados de actividades para desarrollar las competencias de los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.3.4",
        "valor"=> 1,
        "descripcion"=> "Los docentes aplican estrategias para evaluar los desempeños de los estudiantes de forma aislada; dichas estrategias no son comunicadas a los padres de familia ni consideran el proceso de retroalimentación propio de la evaluación formativa."
      ],
      [
          "indice_calificacion"=> "2.3.4",
        "valor"=> 2,
        "descripcion"=> "Las estrategias de evaluación y retroalimenatación del desempeño de los estudiantes son diseñadas teniendo en cuenta los niveles de competencia a alcanzar en cada grado y nivel; son conocidas por la comunidad educativa y son aplicados por algunos docentes."
      ],
      [
          "indice_calificacion"=> "2.3.4",
        "valor"=> 3,
        "descripcion"=> "La evaluación en el aula se desarrolla con criterios claros, acordes con el SIEE, e incluye la retroalimentación como herramienta de la evualuación formativa para el mejoramiento del aprendizaje."
      ],
      [
          "indice_calificacion"=> "2.3.4",
        "valor"=> 4,
        "descripcion"=> "Los procesos de evaluación formativa en el aula son objeto de reflexión y ajuste continuo, con base en el análisis de resultados de evaluaciones internas y externas, con la participación de docentes y estudiantes."
      ],
      [
          "indice_calificacion"=> "2.4.1",
        "valor"=> 1,
        "descripcion"=> "El seguimiento que se hace a los desempeños de los estudiantes es aislado e individual, y no se generan acciones concretas para el fortalecimiento de las competencias."
      ],
      [
          "indice_calificacion"=> "2.4.1",
        "valor"=> 2,
        "descripcion"=> "El seguimiento a los desempeños académicos de los estudiantes se realiza parcialmente y depende de iniciativas individuales de los docentes."
      ],
      [
          "indice_calificacion"=> "2.4.1",
        "valor"=> 3,
        "descripcion"=> "La institución educativa cuenta con un proceso de seguimiento y retroalimentación sistemático a los desempeños de los estudiantes y se aplica de manera oportuna en todos los grados. Además, es conocido por los estudiantes y padres de familia."
      ],
      [
          "indice_calificacion"=> "2.4.1",
        "valor"=> 4,
        "descripcion"=> "La institución revisa periódicamente su proceso de seguimiento a los desempeños de los estudiantes y realiza los ajustes pertinentes, en el marco de la evaluación formativa."
      ],
      [
          "indice_calificacion"=> "2.4.2",
        "valor"=> 1,
        "descripcion"=> "Los resultados de las evaluaciones externas (pruebas SABER y exámenes de Estado) son conocidos por los docentes, pero éstos no se utilizan para diseñar e implementar acciones de mejoramiento."
      ],
      [
          "indice_calificacion"=> "2.4.2",
        "valor"=> 2,
        "descripcion"=> "El análisis de los resultados de los estudiantes en las evaluaciones externas (pruebas SABER y exámenes de Estado) brinda información a los docentes para fortalecer los aprendizajes de los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.4.2",
        "valor"=> 3,
        "descripcion"=> "Las conclusiones de los análisis de los resultados de los estudiantes en las evaluaciones externas (pruebas SABER y exámenes de Estado) son fuente de información para la construcción de los planes de mejoramiento por área y por grado y es aplicado por todos los docentes."
      ],
      [
          "indice_calificacion"=> "2.4.2",
        "valor"=> 4,
        "descripcion"=> "La institución realiza seguimiento a los planes de mejoramiento por área y grado presentados por los docentes, con el fin de fortalecer los aprendizajes no alcanzados por los estudiantes, evidenciados en los resultados de las pruebas externas."
      ],
      [
          "indice_calificacion"=> "2.4.3",
        "valor"=> 1,
        "descripcion"=> "La institución tiene algunas estrategias para controlar el ausentismo, pero éstas se aplican esporádicamente en algunas sedes, y sin indagar sus causas."
      ],
      [
          "indice_calificacion"=> "2.4.3",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con una estrategia para el control, análisis y tratamiento de las causas de ausentismo de los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.4.3",
        "valor"=> 3,
        "descripcion"=> "La estrategia institucional de control, análisis y tratamiento del ausentismo de estudiantes, contempla la participación activa de padres, docentes y estudiantes."
      ],
      [
          "indice_calificacion"=> "2.4.3",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y evalúa periódicamente su estrategia de control y tratamiento del ausentismo de estudiantes en función de los resultados de la misma, e implementa los ajustes pertinentes."
      ],
      [
          "indice_calificacion"=> "2.4.4",
        "valor"=> 1,
        "descripcion"=> "Las acciones de apoyo pedagógico a estudiantes con dificultades de aprendizaje se desarrollan de manera aislada, sin estructurarse en estrategias institucionales claramente definidas."
      ],
      [
          "indice_calificacion"=> "2.4.4",
        "valor"=> 2,
        "descripcion"=> "Se han implementado algunas acciones de apoyo pedagógico, aunque de forma aislada y sin articulación con los planes de aula."
      ],
      [
          "indice_calificacion"=> "2.4.4",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con estrategias organizadas de apoyo pedagógico, articuladas con el PEI, el plan de estudios y las necesidades de los estudiantes."
      ],
      [
          "indice_calificacion"=> "2.4.4",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa sistemáticamente el impacto de las estrategias de apoyo pedagógico y realiza ajustes para garantizar una atención oportuna, equitativa e inclusiva."
      ],
      [
          "indice_calificacion"=> "3.1.1",
        "valor"=> 1,
        "descripcion"=> "El proceso de matrícula se desarrolla sin una planificación institucional unificada y con variaciones entre las sedes, lo que genera dificultades en la organización escolar."
      ],
      [
          "indice_calificacion"=> "3.1.1",
        "valor"=> 2,
        "descripcion"=> "La institución ha definido lineamientos básicos para el proceso de matrícula, aunque su aplicación no es totalmente articulada ni eficiente en todas las sedes."
      ],
      [
          "indice_calificacion"=> "3.1.1",
        "valor"=> 3,
        "descripcion"=> "El proceso de matrícula se ejecuta de manera articulada, oportuna y transparente, garantizando el acceso y la permanencia de todos los estudiantes en igualdad de condiciones."
      ],
      [
          "indice_calificacion"=> "3.1.1",
        "valor"=> 4,
        "descripcion"=> "El proceso de matrícula se evalúa y ajusta anualmente, incorporando mejoras que aseguren su eficiencia, cobertura, inclusión y alineación con la proyección institucional."
      ],
      [
          "indice_calificacion"=> "3.1.2",
        "valor"=> 1,
        "descripcion"=> "La información académica, incluidos los registros de calificaciones y la emisión de boletines, se gestiona de forma manual o dispersa, lo que dificulta su actualización, consulta y uso oportuno para la toma de decisiones."
      ],
      [
          "indice_calificacion"=> "3.1.2",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con un sistema básico de información académica que permite registrar calificaciones y emitir boletines, aunque su uso es parcial, presenta inconsistencias y no se articula plenamente con otros procesos de gestión."
      ],
      [
          "indice_calificacion"=> "3.1.2",
        "valor"=> 3,
        "descripcion"=> "La institución dispone de un sistema de información académica organizado, confiable y actualizado, que integra el registro, archivo y consulta de calificaciones, la generación de boletines escolares y la disponibilidad de información para docentes, estudiantes y familias."
      ],
      [
          "indice_calificacion"=> "3.1.2",
        "valor"=> 4,
        "descripcion"=> "El sistema de información académica es evaluado periódicamente para garantizar su funcionalidad, seguridad y pertinencia. Además, se ajusta para mejorar la gestión de calificaciones, la elaboración de boletines y la disponibilidad de datos que fortalezcan la planeación y el seguimiento académico."
      ],
      [
          "indice_calificacion"=> "3.2.1",
        "valor"=> 1,
        "descripcion"=> "El mantenimiento, adecuación y embellecimiento de la planta física se realiza de forma esporádica y reactiva ante necesidades urgentes, sin una programación institucional. La falta de planificación genera deficiencias en el uso de los espacios y situaciones de hacinamiento en algunas sedes."
      ],
      [
          "indice_calificacion"=> "3.2.1",
        "valor"=> 2,
        "descripcion"=> "Existen acciones básicas para el mantenimiento, adecuación y embellecimiento de la infraestructura, y se identifican necesidades prioritarias para optimizar su uso. Sin embargo, persisten limitaciones que ocasionan sobreocupación de espacios y dificultades para garantizar ambientes adecuados para todos los estudiantes."
      ],
      [
          "indice_calificacion"=> "3.2.1",
        "valor"=> 3,
        "descripcion"=> "La institución implementa un plan organizado de mantenimiento preventivo, adecuación y embellecimiento de la planta física, asegurando el uso eficiente de los espacios y evitando el hacinamiento. Este plan se desarrolla con criterios técnicos y participación de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "3.2.1",
        "valor"=> 4,
        "descripcion"=> "El plan de mantenimiento, adecuación y embellecimiento de la planta física se revisa y evalúa periódicamente, integrando acciones de optimización y reorganización de espacios para prevenir hacinamiento. Los resultados orientan decisiones para garantizar ambientes dignos, seguros y acordes con las necesidades pedagógicas y de bienestar."
      ],
      [
          "indice_calificacion"=> "3.2.2",
        "valor"=> 1,
        "descripcion"=> "La institución cuenta con recursos pedagógicos limitados y desactualizados. La adquisición, distribución, uso y mantenimiento de materiales y suministros no responde a un plan definido, lo que limita su aprovechamiento y actualización oportuna."
      ],
      [
          "indice_calificacion"=> "3.2.2",
        "valor"=> 2,
        "descripcion"=> "Se han establecido lineamientos básicos para la adquisición y dotación de recursos didácticos, así como para el suministro de materiales. Sin embargo, su aplicación es parcial y no garantiza un mantenimiento regular ni un uso planificado."
      ],
      [
          "indice_calificacion"=> "3.2.2",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con un plan institucional para la adquisición, dotación y suministro de recursos para el aprendizaje. Este plan contempla criterios de calidad, pertinencia y equidad, e incluye procedimientos para el mantenimiento preventivo y el uso responsable de los recursos educativos."
      ],
      [
          "indice_calificacion"=> "3.2.2",
        "valor"=> 4,
        "descripcion"=> "El plan de dotación, suministro, mantenimiento y uso de recursos es revisado y evaluado periódicamente. La institución realiza los ajustes necesarios para garantizar la disponibilidad, calidad y aprovechamiento pedagógico de los materiales, en coherencia con los objetivos del PEI y las necesidades de la comunidad educativa."
      ],
            [
                "indice_calificacion"=> "3.2.3",
                "valor"=> 1,
                "descripcion"=> "La institución cuenta con algunos planes de acción para atender accidentes o desastres naturales, pero estos se aplican únicamente en algunas sedes o frente a ciertos riesgos. Además, no existe un proceso de monitoreo ni evaluación sistemática del estado de la infraestructura física para prevenir situaciones que afecten la seguridad escolar."
            ],
            [
                "indice_calificacion"=> "3.2.3",
                "valor"=> 2,
                "descripcion"=> "La institución ha definido un programa básico de seguridad escolar que incluye acciones para la prevención y atención de accidentes y desastres. Sin embargo, su aplicación es parcial y no integra de forma sistemática la revisión del estado de la infraestructura física."
            ],
            [
                "indice_calificacion"=> "3.2.3",
                "valor"=> 3,
                "descripcion"=> "La institución implementa un programa integral de seguridad escolar que articula acciones preventivas y protocolos de atención frente a accidentes, emergencias y desastres, complementados con un plan de mantenimiento y verificación periódica del estado de la infraestructura física."
            ],
            [
                "indice_calificacion"=> "3.2.3",
                "valor"=> 4,
                "descripcion"=> "El programa de seguridad escolar es evaluado y ajustado periódicamente, considerando la gestión de riesgos, el estado de la infraestructura física y la participación de la comunidad educativa. Los resultados orientan acciones para fortalecer una cultura institucional de prevención, autocuidado y respuesta oportuna ante emergencias."
            ],
      [
          "indice_calificacion"=> "3.3.1",
        "valor"=> 1,
        "descripcion"=> "Las estrategias de acceso y permanencia como el PAE o transporte escolar no están garantizadas en todas las sedes y se aplican de forma limitada."
      ],
      [
          "indice_calificacion"=> "3.3.1",
        "valor"=> 2,
        "descripcion"=> "Se han implementado parcialmente programas de acceso y permanencia, aunque su cobertura o seguimiento es insuficiente."
      ],
      [
          "indice_calificacion"=> "3.3.1",
        "valor"=> 3,
        "descripcion"=> "La institución gestiona y articula de manera eficiente las estrategias de acceso y permanencia, garantizando equidad, permanencia y condiciones adecuadas para el aprendizaje."
      ],
      [
          "indice_calificacion"=> "3.3.1",
        "valor"=> 4,
        "descripcion"=> "La cobertura, calidad e impacto de las estrategias de acceso y permanencia son monitoreados y ajustados con enfoque de mejora continua e inclusión."
      ],
      [
          "indice_calificacion"=> "3.4.1",
        "valor"=> 1,
        "descripcion"=> "La asignación académica y de funciones no responde a los perfiles requeridos ni a criterios institucionales definidos."
      ],
      [
          "indice_calificacion"=> "3.4.1",
        "valor"=> 2,
        "descripcion"=> "La institución ha definido criterios para la asignación académica y de funciones, aunque no siempre se ajustan a los perfiles profesionales y formativos."
      ],
      [
          "indice_calificacion"=> "3.4.1",
        "valor"=> 3,
        "descripcion"=> "La asignación académica y de funciones se realiza de forma técnica y transparente, considerando los perfiles, competencias y necesidades institucionales."
      ],
      [
          "indice_calificacion"=> "3.4.1",
        "valor"=> 4,
        "descripcion"=> "La institución revisa y ajusta periódicamente la asignación académica y funcional, promoviendo una distribución equitativa y eficiente del talento humano."
      ],
      [
          "indice_calificacion"=> "3.4.2",
        "valor"=> 1,
        "descripcion"=> "La institución no cuenta con un programa de formación institucional estructurado y las actividades de capacitación son esporádicas o individuales."
      ],
      [
          "indice_calificacion"=> "3.4.2",
        "valor"=> 2,
        "descripcion"=> "Se desarrollan acciones formativas con base en necesidades identificadas, aunque no están articuladas a un plan institucional ni se hace seguimiento sistemático."
      ],
      [
          "indice_calificacion"=> "3.4.2",
        "valor"=> 3,
        "descripcion"=> "La institución implementa un programa institucional de formación y actualización docente y administrativa, en coherencia con el PEI y las prioridades del contexto."
      ],
      [
          "indice_calificacion"=> "3.4.2",
        "valor"=> 4,
        "descripcion"=> "El programa de formación es evaluado periódicamente, se ajusta en función de su impacto, y promueve procesos de desarrollo profesional continuo."
      ],
      [
          "indice_calificacion"=> "3.4.3",
        "valor"=> 1,
        "descripcion"=> "El personal manifiesta escaso sentido de pertenencia institucional y su vinculación con los procesos escolares es limitada."
      ],
      [
          "indice_calificacion"=> "3.4.3",
        "valor"=> 2,
        "descripcion"=> "Se desarrollan acciones para fortalecer el sentido de pertenencia del personal, aunque aún no se evidencia de forma generalizada."
      ],
      [
          "indice_calificacion"=> "3.4.3",
        "valor"=> 3,
        "descripcion"=> "El personal vinculado demuestra compromiso con los valores y metas institucionales, y participa activamente en los procesos de mejoramiento institucional."
      ],
      [
          "indice_calificacion"=> "3.4.3",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa las acciones de integración, bienestar y reconocimiento al personal, y las ajusta para promover identidad institucional y compromiso sostenido."
      ],
      [
          "indice_calificacion"=> "3.4.4",
        "valor"=> 1,
        "descripcion"=> "La evaluación del desempeño se realiza de manera informal y no cuenta con criterios institucionales claros ni seguimiento. No existe articulación con el plan de mejoramiento institucional."
      ],
      [
          "indice_calificacion"=> "3.4.4",
        "valor"=> 2,
        "descripcion"=> "Se han definido criterios básicos para la evaluación del desempeño, aunque su aplicación es parcial, carece de retroalimentación efectiva y no siempre está armonizada con el plan de mejoramiento o con los lineamientos de la Guía 31 del MEN."
      ],
      [
          "indice_calificacion"=> "3.4.4",
        "valor"=> 3,
        "descripcion"=> "La evaluación del desempeño se aplica de forma técnica y participativa, alineada con los lineamientos de la Guía 31 del MEN y articulada al plan de mejoramiento institucional, y se utiliza para identificar necesidades de formación y fortalecer la calidad de la gestión educativa."
      ],
      [
          "indice_calificacion"=> "3.4.4",
        "valor"=> 4,
        "descripcion"=> "Los resultados de la evaluación del desempeño, armonizados con el plan de mejoramiento institucional y en coherencia con la Guía 31 del MEN, son analizados, socializados y utilizados como base para definir acciones de desarrollo profesional y mejora continua."
      ],
      [
          "indice_calificacion"=> "3.4.5",
        "valor"=> 1,
        "descripcion"=> "La institución no cuenta con procedimientos ni protocolos claros para la prevención, mediación y solución de conflictos entre el personal, por lo que los desacuerdos suelen gestionarse de forma improvisada o reactiva, generando tensiones en el clima laboral."
      ],
      [
          "indice_calificacion"=> "3.4.5",
        "valor"=> 2,
        "descripcion"=> "Existen lineamientos básicos para la convivencia y el manejo de conflictos entre el personal, pero su aplicación es parcial y depende de iniciativas individuales de directivos o líderes, sin un seguimiento sistemático."
      ],
      [
          "indice_calificacion"=> "3.4.5",
        "valor"=> 3,
        "descripcion"=> "La institución dispone de estrategias claras para la mediación y solución de conflictos entre el personal, y éstos se resuelven a través del diálogo y la negociación permanente. Esto contribuye a mantener un ambiente de respeto, cooperación y buen clima laboral."
      ],
      [
          "indice_calificacion"=> "3.4.5",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa periódicamente la efectividad de las estrategias de convivencia y manejo de conflictos del personal, ajusta los procedimientos con base en los resultados y fomenta una cultura de respeto, diálogo y corresponsabilidad que fortalece la armonía y la productividad institucional."
      ],
      [
          "indice_calificacion"=> "3.5.1",
        "valor"=> 1,
        "descripcion"=> "La elaboración y ejecución del presupuesto del FSE se realiza sin participación ni articulación con el direccionamiento estratégico."
      ],
      [
          "indice_calificacion"=> "3.5.1",
        "valor"=> 2,
        "descripcion"=> "El presupuesto se formula con base en necesidades generales, pero requiere mayor articulación con los planes institucionales."
      ],
      [
          "indice_calificacion"=> "3.5.1",
        "valor"=> 3,
        "descripcion"=> "El presupuesto del FSE se formula, ejecuta y monitorea de manera técnica, participativa y en función de los objetivos institucionales."
      ],
      [
          "indice_calificacion"=> "3.5.1",
        "valor"=> 4,
        "descripcion"=> "El manejo del presupuesto del FSE es evaluado anualmente, y sus ajustes responden a la eficiencia, la equidad y la sostenibilidad de la gestión institucional."
      ],
      [
          "indice_calificacion"=> "3.5.2",
        "valor"=> 1,
        "descripcion"=> "Los registros contables de ingresos y egresos se llevan de forma básica, desactualizada o fragmentada, sin procedimientos claros para el recaudo ni para la ejecución de gastos, lo que limita el seguimiento y la toma de decisiones financieras."
      ],
      [
          "indice_calificacion"=> "3.5.2",
        "valor"=> 2,
        "descripcion"=> "Existen procedimientos básicos para registrar y controlar ingresos y egresos, aunque su aplicación es parcial y no siempre se articula con la planeación financiera institucional ni se socializa de manera suficiente con la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "3.5.2",
        "valor"=> 3,
        "descripcion"=> "Hay procesos claros para el recaudo de ingresos y la realización de gastos; estos son conocidos por la comunidad educativa y su funcionamiento es coherente con la planeación financiera de la institución. La contabilidad se lleva de forma actualizada y cumple con los requisitos normativos."
      ],
      [
          "indice_calificacion"=> "3.5.2",
        "valor"=> 4,
        "descripcion"=> "La contabilidad institucional, que incluye la gestión transparente de ingresos y egresos, es auditada y evaluada periódicamente. Los resultados orientan ajustes para optimizar la administración de recursos y fortalecer la confianza de la comunidad en la gestión financiera."
      ],
      [
          "indice_calificacion"=> "3.5.3",
        "valor"=> 1,
        "descripcion"=> "Los procesos de contratación se realizan de manera informal o reactiva, sin un procedimiento institucional claramente definido ni un ajuste riguroso a los lineamientos legales vigentes.\n"
      ],
      [
          "indice_calificacion"=> "3.5.3",
        "valor"=> 2,
        "descripcion"=> "La institución ha definido lineamientos básicos de contratación de acuerdo con su manual institucional y la normativa, pero su aplicación es parcial y no siempre garantiza principios de transparencia, equidad y planeación."
      ],
      [
          "indice_calificacion"=> "3.5.3",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con un proceso de contratación estructurado, ajustado a su manual institucional y a los requerimientos de ley. Este proceso asegura la planeación, selección y ejecución de contratos con criterios de pertinencia, transparencia y eficiencia."
      ],
      [
          "indice_calificacion"=> "3.5.3",
        "valor"=> 4,
        "descripcion"=> "El proceso de contratación se evalúa y ajusta periódicamente para garantizar su alineación con el manual institucional, el cumplimiento de la normativa vigente y la coherencia con la planeación estratégica y financiera de la institución."
      ],
      [
          "indice_calificacion"=> "3.5.4",
        "valor"=> 1,
        "descripcion"=> "Los informes financieros presentados por la institución a las autoridades competentes no siempre se hacen de manera oportuna y no son conocidos por la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "3.5.4",
        "valor"=> 2,
        "descripcion"=> "Existen procedimientos básicos de control fiscal, aunque su aplicación no es sistemática ni los da a conocer a la\ncomunidad educativa. "
      ],
      [
          "indice_calificacion"=> "3.5.4",
        "valor"=> 3,
        "descripcion"=> "La institución desarrolla mecanismos de control fiscal eficaces, articulados al proceso de planeación, ejecución y evaluación institucional. Éstos son parte del proceso de control interno y sirven para tomar decisiones y realizar seguimiento al manejo de los recursos."
      ],
      [
          "indice_calificacion"=> "3.5.4",
        "valor"=> 4,
        "descripcion"=> "El control fiscal es parte de una cultura institucional de transparencia, se evalúa periódicamente y sus resultados orientan decisiones de mejora."
      ],
      [
          "indice_calificacion"=> "4.1.1",
        "valor"=> 1,
        "descripcion"=> "La atención a poblaciones diversas se realiza de manera asistencial, aislada y sin un enfoque pedagógico diferencial ni articulación con los procesos institucionales. Las acciones no se visibilizan ni se socializan con la comunidad."
      ],
      [
          "indice_calificacion"=> "4.1.1",
        "valor"=> 2,
        "descripcion"=> "Existen lineamientos básicos para la atención educativa a grupos poblacionales o en situación de vulnerabilidad, pero su aplicación es parcial y depende de iniciativas individuales, sin seguimiento integral ni amplia divulgación."
      ],
      [
          "indice_calificacion"=> "4.1.1",
        "valor"=> 3,
        "descripcion"=> "La institución trabaja articuladamente para diseñar y aplicar estrategias pedagógicas pertinentes que permitan integrar y atender a personas pertenecientes a grupos étnicos o en situación de vulnerabilidad. Estas estrategias se socializan y se dan a conocer a toda la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "4.1.1",
        "valor"=> 4,
        "descripcion"=> "Las estrategias de atención educativa a grupos poblacionales o en situación de vulnerabilidad se evalúan y ajustan periódicamente, articulándose de forma efectiva al PEI, al plan de estudios y a la gestión institucional, garantizando inclusión, equidad y participación."
      ],
      [
          "indice_calificacion"=> "4.1.2",
        "valor"=> 1,
        "descripcion"=> "No se realizan acciones institucionales sistemáticas para identificar ni atender las necesidades, intereses y expectativas de los estudiantes."
      ],
      [
          "indice_calificacion"=> "4.1.2",
        "valor"=> 2,
        "descripcion"=> "Se han desarrollado mecanismos parciales para recoger información sobre las necesidades y expectativas estudiantiles, aunque sin seguimiento integral."
      ],
      [
          "indice_calificacion"=> "4.1.2",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con mecanismos que le permiten identificar, analizar y atender de forma sistemática las necesidades, expectativas e intereses de los estudiantes, integrándolos en los procesos educativos y de gestión, y dándolos a conocer de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "4.1.2",
        "valor"=> 4,
        "descripcion"=> "Los mecanismos de atención a las expectativas de los estudiantes se evalúan y ajustan regularmente para mejorar la pertinencia de la oferta educativa."
      ],
      [
          "indice_calificacion"=> "4.1.3",
        "valor"=> 1,
        "descripcion"=> "La institución cuenta con algunas iniciativas para apoyar a los estudiantes en la formulación de sus proyectos de vida; sin embargo, estas no se encuentran articuladas con otros procesos."
      ],
      [
          "indice_calificacion"=> "4.1.3",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con programas concertados con el cuerpo docente para acompañar a los estudiantes en la construcción de sus proyectos de vida. Estos programas se articulan con la identificación de sus necesidades y expectativas, así como con las oportunidades que ofrece el entorno para su desarrollo integral."
      ],
      [
          "indice_calificacion"=> "4.1.3",
        "valor"=> 3,
        "descripcion"=> "La institución manifiesta de forma programática su interés en la proyección personal y el futuro de los estudiantes; este programa es reconocido, apoyado y enriquecido por toda la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "4.1.3",
        "valor"=> 4,
        "descripcion"=> "La institución evalúa y fortalece continuamente los procesos relacionados con los proyectos de vida de sus estudiantes, demostrando así un compromiso por cualificar este aspecto dentro de su formación integral."
      ],
      [
          "indice_calificacion"=> "4.2.1",
        "valor"=> 1,
        "descripcion"=> "La institución brinda a los padres de familia talleres y charlas sobre diferentes temáticas, aunque carecen de una programación clara y estructurada."
      ],
      [
          "indice_calificacion"=> "4.2.1",
        "valor"=> 2,
        "descripcion"=> "La escuela de padres cuenta con una programación básica, aunque su ejecución es irregular y con baja participación."
      ],
      [
          "indice_calificacion"=> "4.2.1",
        "valor"=> 3,
        "descripcion"=> "La escuela de padres desarrolla actividades formativas articuladas al PEI y a las necesidades de las familias, con participación representativa."
      ],
      [
          "indice_calificacion"=> "4.2.1",
        "valor"=> 4,
        "descripcion"=> "La escuela de padres es evaluada y fortalecida de manera continua, consolidándose como un espacio de formación, participación y corresponsabilidad educativa."
      ],
      [
          "indice_calificacion"=> "4.2.2",
        "valor"=> 1,
        "descripcion"=> "La institución tiene iniciativas de servicio a la comunidad, aunque no están organizadas como parte de un plan institucional."
      ],
      [
          "indice_calificacion"=> "4.2.2",
        "valor"=> 2,
        "descripcion"=> "La institución cuenta con estrategias de comunicación que favorecen el conocimiento recíproco con la comunidad; las actividades se planifican de manera conjunta, aun cuando no guarden una relación directa con el PEI."
      ],
      [
          "indice_calificacion"=> "4.2.2",
        "valor"=> 3,
        "descripcion"=> "La institución desarrolla una oferta organizada de servicios para la comunidad, en coherencia con el PEI y las necesidades del entorno."
      ],
      [
          "indice_calificacion"=> "4.2.2",
        "valor"=> 4,
        "descripcion"=> "La oferta de servicios a la comunidad es evaluada, fortalecida y ampliada continuamente, fomentando el compromiso social de la institución."
      ],
      [
          "indice_calificacion"=> "4.2.3",
        "valor"=> 1,
        "descripcion"=> "El servicio social estudiantil se desarrolla como un requisito formal, sin orientación ni articulación con procesos de formación ciudadana."
      ],
      [
          "indice_calificacion"=> "4.2.3",
        "valor"=> 2,
        "descripcion"=> "El servicio social estudiantil cuenta con lineamientos básicos y se ejecuta parcialmente como una estrategia pedagógica que responde a las necesidades de la comunidad."
      ],
      [
          "indice_calificacion"=> "4.2.3",
        "valor"=> 3,
        "descripcion"=> "El servicio social estudiantil se desarrolla como una experiencia significativa que promueve la participación, la ciudadanía y la proyección social de los estudiantes, y este contribuye a la solución de las necesidades de la comunidad."
      ],
      [
          "indice_calificacion"=> "4.2.3",
        "valor"=> 4,
        "descripcion"=> "El programa de servicio social estudiantil es monitoreado, evaluado y ajustado periódicamente, fortaleciendo su impacto en la comunidad y en la formación integral de los estudiantes."
      ],
      [
          "indice_calificacion"=> "4.3.1",
        "valor"=> 1,
        "descripcion"=> "La participación de los estudiantes es limitada y no existen mecanismos efectivos para garantizar su representación y protagonismo."
      ],
      [
          "indice_calificacion"=> "4.3.1",
        "valor"=> 2,
        "descripcion"=> "Existen espacios de participación estudiantil, aunque su funcionamiento no es constante ni articulado a la gestión institucional."
      ],
      [
          "indice_calificacion"=> "4.3.1",
        "valor"=> 3,
        "descripcion"=> "La institución promueve activamente la participación de los estudiantes en procesos decisorios, pedagógicos y de convivencia."
      ],
      [
          "indice_calificacion"=> "4.3.1",
        "valor"=> 4,
        "descripcion"=> "La participación estudiantil es monitoreada y fortalecida sistemáticamente como expresión del ejercicio de la ciudadanía escolar."
      ],
      [
          "indice_calificacion"=> "4.4.1",
        "valor"=> 1,
        "descripcion"=> "La prevención de riesgos físicos requiere la definición de estrategias institucionales claras y la implementación de protocolos específicos."
      ],
      [
          "indice_calificacion"=> "4.4.1",
        "valor"=> 2,
        "descripcion"=> "Se han definido algunas acciones preventivas frente a riesgos físicos, aunque su implementación es parcial y poco sistemática."
      ],
      [
          "indice_calificacion"=> "4.4.1",
        "valor"=> 3,
        "descripcion"=> "La institución cuenta con un plan integral de prevención de riesgos físicos, socializado y puesto en práctica por toda la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "4.4.1",
        "valor"=> 4,
        "descripcion"=> "El plan de prevención de riesgos físicos es evaluado y actualizado de forma periódica, fortaleciendo la seguridad y el bienestar de todos los miembros de la comunidad educativa."
      ],
      [
          "indice_calificacion"=> "4.4.2",
        "valor"=> 1,
        "descripcion"=> "Se han implementado acciones para prevenir riesgos psicosociales, aunque no están articuladas ni se aplican en todas las sedes."
      ],
      [
          "indice_calificacion"=> "4.4.2",
        "valor"=> 2,
        "descripcion"=> "La institución detecta factores de riesgo como ETS, embarazo adolescente y violencia, y desarrolla acciones preventivas basadas en sus diagnósticos y en los de otras entidades."
      ],
      [
          "indice_calificacion"=> "4.4.2",
        "valor"=> 3,
        "descripcion"=> "La institución, con apoyo de entidades externas, implementa programas para sensibilizar a estudiantes y comunidad sobre riesgos y fortalecer la cultura de autocuidado y prevención, con participación activa y seguimiento a los factores de riesgo detectados."
      ],
      [
          "indice_calificacion"=> "4.4.2",
        "valor"=> 4,
        "descripcion"=> "Las estrategias de prevención de riesgos psicosociales son evaluadas y mejoradas periódicamente, fortaleciendo el ambiente escolar y el desarrollo integral de los estudiantes."
      ]
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
