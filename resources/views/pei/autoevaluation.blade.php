@extends('layouts.app')

@section('content')
  <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-header"><center><h2>AUTOEVALUACIÓN INSTITUCIONAL</h2></center></h5>
                      <div class="col-md-12">
                        <div class="card text-center mb-3">
                            <div class="card-header border-bottom">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                  <li class="nav-item">
                                      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-directiva" aria-controls="navs-tab-gestion-directiva" aria-selected="true">1. GESTIÓN DIRECTIVA</button>
                                  </li>
                                  <li class="nav-item">
                                      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-academica" aria-controls="navs-tab-gestion-academica" aria-selected="true">2. GESTIÓN ACADEMICA</button>
                                  </li>
                                  <li class="nav-item">
                                      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-administrativa" aria-controls="navs-tab-gestion-administrativa" aria-selected="true">3. GESTIÓN ADMINISTRATIVA Y FINANCIERA</button>
                                  </li>
                                  <li class="nav-item">
                                      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-comunidad" aria-controls="navs-tab-gestion-comunidad" aria-selected="true">4. GESTIÓN DE LA COMUNIDAD</button>
                                  </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="navs-tab-gestion-directiva" role="tabpanel">
                                    <div class="card-datatable table-responsive pt-0">
                                      <table border="1">
                                        <tr>
                                            <th colspan="2">GESTIONES / PROCESOS / COMPONENTES</th>
                                            <th>Nivel</th>
                                            <th colspan="2">AÑO:</th>
                                            <th>EVIDENCIAS</th>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="background-color: #A52A2A; color: white;"><b>1. GESTIÓN DIRECTIVA</b></td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">1.1. <strong>Direccionamiento Estratégico</strong></th>
                                        </tr>
                                        <tr>
                                          <td>1.1.1.</td>
                                          <td>Misión, visión y principios, en el marco de una institución integrada</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1" selected>1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" >4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #FFD700;">Apropiación</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>1.1.2.</td>
                                          <td>Metas institucionales</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>1.1.3.</td>
                                          <td>Política de inclusión de personas de diferentes grupos poblacionales o diversidad cultural</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>total Proceso</b></td>
                                            <td colspan="2"><b>3,67</b></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">1.2. <strong>Gestión Estratégica</strong></th>
                                        </tr>
                                        <tr>
                                            <td>1.2.1</td>
                                            <td>Liderazgo y trabajo en equipo</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se unifica con 1.4.2. "Trabajo en equipo". Se debe unificar los descriptores.</td>
                                        </tr>
                                        <tr>
                                            <td>1.2.2</td>
                                            <td>Articulación de planes, proyectos y acciones</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>1.2.5</td>
                                            <td>Seguimiento y autoevaluación</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se ajustó descriptor 3.</td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Proceso: <strong>4,00</strong></th>
                                        </tr>

                                        <tr>
                                            <th colspan="6">1.3. <strong>Gobierno Escolar</strong></th>
                                        </tr>
                                        <tr>
                                            <td>1.3.1</td>
                                            <td>Consejo directivo</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>1.3.2</td>
                                            <td>Consejo académico</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>1.3.4</td>
                                            <td>Comité de convivencia</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3" selected >3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="existencia">Existencia</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>1.3.5</td>
                                            <td>Consejo estudiantil</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>1.3.6</td>
                                            <td>Personero estudiantil</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>1.3.7</td>
                                            <td>Asamblea de padres de familia</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se unifica con 4.3.1 y 4.3.2; se deben unificar descriptores</td>
                                        </tr>
                                        <tr>
                                            <td>1.3.8</td>
                                            <td>Consejo de padres de familia</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se unifica con 4.3.1 y 4.3.2; se deben unificar descriptores</td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Proceso: <strong>3,14</strong></th>
                                        </tr>
                                        <tr class="categoria">
                                          <th colspan="6">1.4 Cultura Institucional</th>
                                        </tr>
                                        <tr>
                                            <td>1.4.1</td>
                                            <td>Política de comunicación institucional</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Cambiar el nombre a "Política de Comunicación".</td>
                                        </tr>
                                        <tr>
                                            <td>1.4.3</td>
                                            <td>Política de bienestar</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se unifica con 3.4.7 "Estímulos" y 3.4.10 "Bienestar del Talento Humano".</td>
                                        </tr>
                                        <tr>
                                            <td>1.4.4</td>
                                            <td>Apoyo a la investigación y divulgación de buenas prácticas</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se unifica con 3.4.8 "Apoyo a la investigación".</td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">Total Proceso: <strong>4</strong></th>
                                        </tr>
                                        <tr class="categoria">
                                            <th colspan="6">1.5 Clima Escolar</th>
                                        </tr>
                                        <tr>
                                            <td>1.5.1</td>
                                            <td>Sentido de pertenencia y participación</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Modificar descriptores teniendo en cuenta escalas valorativas.</td>
                                        </tr>
                                        <tr>
                                            <td>1.5.2</td>
                                            <td>Ambiente físico</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Unir a infraestructura en gestión administrativa.</td>
                                        </tr>
                                        <tr>
                                            <td>1.5.3</td>
                                            <td>Programa de inducción institucional</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Cambia de nombre a "Programa de inducción institucional".</td>
                                        </tr>
                                        <tr>
                                            <td>1.5.4</td>
                                            <td>Motivación hacia el aprendizaje</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Trasladar a Gestión académica.</td>
                                        </tr>
                                        <tr>
                                            <td>1.5.5</td>
                                            <td>Manual de convivencia</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>1.5.6</td>
                                          <td>Actividades extracurriculares</td>
                                          <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                          <td class="mejoramiento">Mejoramiento</td>
                                          <td colspan="2"></td>
                                      </tr>
                                      <tr>
                                        <td>1.5.8</td>
                                        <td>Manejo de conflictos y casos díficiles.</td>
                                        <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                        <td class="mejoramiento">Mejoramiento</td>
                                        <td colspan="2"></td>
                                    </tr>
                                        <tr>
                                          <th colspan="6">Total Proceso: <strong>4</strong></th>
                                        </tr>
                                        <tr class="categoria">
                                            <th colspan="6">1.6 Relaciones Con El Entorno</th>
                                        </tr>
                                        <tr>
                                            <td>1.6.1</td>
                                            <td>Familias o acudientes</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Unir con 4.3.3 "Participación de las familias".</td>
                                        </tr>
                                        <tr>
                                            <td>2.4.6</td>
                                            <td>Relaciones con los egresados</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se trae de gestión académica, seguimiento.</td>
                                        </tr>
                                        <tr>
                                            <td>1.6.3</td>
                                            <td>Alianzas, acuerdos y proyectos con otras instituciones</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Modificar descriptores.</td>
                                        </tr>
                                        <tr>
                                            <td>1.6.4</td>
                                            <td>Alianzas con el sector productivo</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Modificar descriptores.</td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">Total Proceso: <strong>4</strong></th>
                                        </tr>
                                        <tr>
                                          <th colspan="6"><h5>Total de la Gestion Directiva:</h5><strong>3,80</strong></th>
                                        </tr>
                                      </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-tab-gestion-academica" role="tabpanel">
                                    <div class="card-datatable table-responsive pt-0">
                                      <table border="1">
                                        <tr>
                                            <td colspan="6" style="background-color: #A52A2A; color: white;"><b>2. GESTIÓN ACADEMICA</b></td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">2.1. <strong>Diseño pedagogico</strong></th>
                                        </tr>
                                        <tr>
                                          <td>2.1.1.</td>
                                          <td>plan de estudios</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1" selected>1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" >4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #FFD700;">Apropiación</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>2.1.2.</td>
                                          <td>Enfoque metodologico</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>2.1.3.</td>
                                          <td>estrategia pedagogica</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>2.1.4</td>
                                            <td>Jornada escolar</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>2.1.5</td>
                                            <td>sistema de los estudiantes</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Proceso: <strong>4,00</strong></th>
                                        </tr>

                                        <tr>
                                            <th colspan="6">2.2 <strong>{Practicas pedagogicas}</strong></th>
                                        </tr>
                                        <tr>
                                            <td>2.2.1</td>
                                            <td>Estrategias para tareas escolares</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>2.2.2</td>
                                            <td>Uso articulado de los recursos para el apredizaje</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">2.3 <strong>Gestion del aula</strong></th>
                                        </tr>
                                        <tr>
                                            <td>2.3.1</td>
                                            <td>Ambientes de aprendizaje</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>2.3.2</td>
                                            <td>Plan de aula, opciones didácticas y temas de enseñanza obligatoria</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                      </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                    <div class="card-datatable table-responsive pt-0">
                                      <table border="1">
                                        <tr>
                                            <td colspan="6" style="background-color: #A52A2A; color: white;"><b>3. GESTIÓN ADMINISTRATIVA Y FINANCIERA</b></td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">3.1. <strong>Apoyo a la gestion academica</strong></th>
                                        </tr>
                                        <tr>
                                          <td>3.1.1.</td>
                                          <td>Proceso de matricula</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1" selected>1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" >4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #FFD700;">Apropiación</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>3.1.2.</td>
                                          <td>Sistema de informacion academica</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">3.2. <strong>Administracion de la planta fisica y de los recursos</strong></th>
                                        </tr>
                                        <tr>
                                          <td>3.2.1.</td>
                                          <td>Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>3.2.2.</td>
                                          <td>Dotación, mantenimiento y uso de recursos para el aprendizaje</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>total Proceso</b></td>
                                            <td colspan="2"><b>3,67</b></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">3.3. <strong>Administracion de los servicios complementarios</strong></th>
                                        </tr>
                                        <tr>
                                            <td>3.3.1</td>
                                            <td>Estrategias de acceso y permanencia (PAE, transporte escolar y otros).</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se unifica con 1.4.2. "Trabajo en equipo". Se debe unificar los descriptores.</td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Proceso: <strong>4,00</strong></th>
                                        </tr>

                                        <tr>
                                            <th colspan="6">3.4. <strong>Talento Humano</strong></th>
                                        </tr>
                                        <tr>
                                            <td>3.4.1</td>
                                            <td>Perfiles, asignación académica y de funciones</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                      </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                                    <div class="card-datatable table-responsive pt-0">
                                      <table border="1">
                                        <tr>
                                            <td colspan="6" style="background-color: #A52A2A; color: white;"><b>4. GESTIÓN DE LA COMUNIDAD</b></td>
                                        </tr>
                                        <tr>
                                          <th colspan="6">4.1. <strong>Accesibilidad</strong></th>
                                        </tr>
                                        <tr>
                                          <td>4.1.1.</td>
                                          <td>Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1" selected>1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" >4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #FFD700;">Apropiación</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>4.1.2.</td>
                                          <td>Necesidades y expectativas de los estudiantes</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                          <td>4.1.3.</td>
                                          <td>proyectos de vida</td>
                                          <td>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1">1</option>
                                              <option value="2">2</option>
                                              <option value="3">3</option>
                                              <option value="4" selected>4</option>
                                            </select>
                                          </td>
                                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                                          <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>total Proceso</b></td>
                                            <td colspan="2"><b>3,67</b></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">4.2. <strong>Proyeccion a la comunidad</strong></th>
                                        </tr>
                                        <tr>
                                            <td>4.2.1</td>
                                            <td>escuela de padres</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se unifica con 1.4.2. "Trabajo en equipo". Se debe unificar los descriptores.</td>
                                        </tr>
                                        <tr>
                                            <td>4.2.2</td>
                                            <td>Oferta de servicios a la comunidad</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>4.2.3</td>
                                            <td>Programa de servicio social institucional</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4" selected>4</option>
                                              </select>
                                            </td>
                                            <td class="mejoramiento">Mejoramiento</td>
                                            <td colspan="2">Se ajustó descriptor 3.</td>
                                        </tr>
                                        <tr>
                                            <th colspan="6">Total Proceso: <strong>4,00</strong></th>
                                        </tr>

                                        <tr>
                                            <th colspan="6">4.4. <strong>Prevencion de riezgos</strong></th>
                                        </tr>
                                        <tr>
                                            <td>4.4.1</td>
                                            <td>Prevencion de riezgos fisicos</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td>4.4.2</td>
                                            <td>Prevencion de riezgos psicosociales</td>
                                            <td>
                                              <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                              </select>
                                            </td>
                                            <td class="apropiacion">Apropiación</td>
                                            <td colspan="2"></td>
                                        </tr>
                                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      <!-- <table border="1">
                        <tr>
                            <th colspan="2">GESTIONES / PROCESOS / COMPONENTES</th>
                            <th>Nivel</th>
                            <th colspan="2">AÑO:</th>
                            <th>EVIDENCIAS</th>
                        </tr>
                        <tr>
                            <td colspan="6" style="background-color: #A52A2A; color: white;"><b>1. GESTIÓN DIRECTIVA</b></td>
                        </tr>
                        <tr>
                          <th colspan="6">1.1. <strong>Direccionamiento Estratégico</strong></th>
                        </tr>
                        <tr>
                          <td>1.1.1.</td>
                          <td>Misión, visión y principios, en el marco de una institución integrada</td>
                          <td>
                            <select class="form-control" name="valoracion" id="valoracion">
                              <option value="1" selected>1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4" >4</option>
                            </select>
                          </td>
                          <td style="background-color: #FFD700;">Apropiación</td>
                          <td colspan="2"></td>
                        </tr>
                        <tr>
                          <td>1.1.2.</td>
                          <td>Metas institucionales</td>
                          <td>
                            <select class="form-control" name="valoracion" id="valoracion">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4" selected>4</option>
                            </select>
                          </td>
                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                          <td colspan="2"></td>
                        </tr>
                        <tr>
                          <td>1.1.3.</td>
                          <td>Política de inclusión de personas de diferentes grupos poblacionales o diversidad cultural</td>
                          <td>
                            <select class="form-control" name="valoracion" id="valoracion">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4" selected>4</option>
                            </select>
                          </td>
                          <td style="background-color: #008000; color: white;">Mejoramiento</td>
                          <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>total Proceso</b></td>
                            <td colspan="2"><b>3,67</b></td>
                        </tr>
                        <tr>
                            <th colspan="6">1.2. <strong>Gestión Estratégica</strong></th>
                        </tr>
                        <tr>
                            <td>1.2.1</td>
                            <td>Liderazgo y trabajo en equipo</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Se unifica con 1.4.2. "Trabajo en equipo". Se debe unificar los descriptores.</td>
                        </tr>
                        <tr>
                            <td>1.2.2</td>
                            <td>Articulación de planes, proyectos y acciones</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>1.2.5</td>
                            <td>Seguimiento y autoevaluación</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Se ajustó descriptor 3.</td>
                        </tr>
                        <tr>
                            <th colspan="6">Total Proceso: <strong>4,00</strong></th>
                        </tr>

                        <tr>
                            <th colspan="6">1.3. <strong>Gobierno Escolar</strong></th>
                        </tr>
                        <tr>
                            <td>1.3.1</td>
                            <td>Consejo directivo</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                              </select>
                            </td>
                            <td class="apropiacion">Apropiación</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>1.3.2</td>
                            <td>Consejo académico</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>1.3.4</td>
                            <td>Comité de convivencia</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3" selected >3</option>
                                <option value="4">4</option>
                              </select>
                            </td>
                            <td class="existencia">Existencia</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>1.3.5</td>
                            <td>Consejo estudiantil</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>1.3.6</td>
                            <td>Personero estudiantil</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>1.3.7</td>
                            <td>Asamblea de padres de familia</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Se unifica con 4.3.1 y 4.3.2; se deben unificar descriptores</td>
                        </tr>
                        <tr>
                            <td>1.3.8</td>
                            <td>Consejo de padres de familia</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Se unifica con 4.3.1 y 4.3.2; se deben unificar descriptores</td>
                        </tr>
                        <tr>
                            <th colspan="6">Total Proceso: <strong>3,14</strong></th>
                        </tr>
                        <tr class="categoria">
                          <th colspan="6">1.4 Cultura Institucional</th>
                        </tr>
                        <tr>
                            <td>1.4.1</td>
                            <td>Política de comunicación institucional</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Cambiar el nombre a "Política de Comunicación".</td>
                        </tr>
                        <tr>
                            <td>1.4.3</td>
                            <td>Política de bienestar</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Se unifica con 3.4.7 "Estímulos" y 3.4.10 "Bienestar del Talento Humano".</td>
                        </tr>
                        <tr>
                            <td>1.4.4</td>
                            <td>Apoyo a la investigación y divulgación de buenas prácticas</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Se unifica con 3.4.8 "Apoyo a la investigación".</td>
                        </tr>
                        <tr>
                          <th colspan="6">Total Proceso: <strong>4</strong></th>
                        </tr>
                        <tr class="categoria">
                            <th colspan="6">1.5 Clima Escolar</th>
                        </tr>
                        <tr>
                            <td>1.5.1</td>
                            <td>Sentido de pertenencia y participación</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Modificar descriptores teniendo en cuenta escalas valorativas.</td>
                        </tr>
                        <tr>
                            <td>1.5.2</td>
                            <td>Ambiente físico</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Unir a infraestructura en gestión administrativa.</td>
                        </tr>
                        <tr>
                            <td>1.5.3</td>
                            <td>Programa de inducción institucional</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Cambia de nombre a "Programa de inducción institucional".</td>
                        </tr>
                        <tr>
                            <td>1.5.4</td>
                            <td>Motivación hacia el aprendizaje</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Trasladar a Gestión académica.</td>
                        </tr>
                        <tr>
                            <td>1.5.5</td>
                            <td>Manual de convivencia</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                          <td>1.5.6</td>
                          <td>Actividades extracurriculares</td>
                          <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                          <td class="mejoramiento">Mejoramiento</td>
                          <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td>1.5.8</td>
                        <td>Manejo de conflictos y casos díficiles.</td>
                        <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                        <td class="mejoramiento">Mejoramiento</td>
                        <td colspan="2"></td>
                    </tr>
                        <tr>
                          <th colspan="6">Total Proceso: <strong>4</strong></th>
                        </tr>
                        <tr class="categoria">
                            <th colspan="6">1.6 Relaciones Con El Entorno</th>
                        </tr>
                        <tr>
                            <td>1.6.1</td>
                            <td>Familias o acudientes</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Unir con 4.3.3 "Participación de las familias".</td>
                        </tr>
                        <tr>
                            <td>2.4.6</td>
                            <td>Relaciones con los egresados</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Se trae de gestión académica, seguimiento.</td>
                        </tr>
                        <tr>
                            <td>1.6.3</td>
                            <td>Alianzas, acuerdos y proyectos con otras instituciones</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Modificar descriptores.</td>
                        </tr>
                        <tr>
                            <td>1.6.4</td>
                            <td>Alianzas con el sector productivo</td>
                            <td>
                              <select class="form-control" name="valoracion" id="valoracion">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4" selected>4</option>
                              </select>
                            </td>
                            <td class="mejoramiento">Mejoramiento</td>
                            <td colspan="2">Modificar descriptores.</td>
                        </tr>
                        <tr>
                          <th colspan="6">Total Proceso: <strong>4</strong></th>
                        </tr>
                        <tr>
                          <th colspan="6"><h5>Total de la Gestion Directiva:</h5><strong>3,80</strong></th>
                        </tr>
                      </table>                     -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection
