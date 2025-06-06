@extends('layouts.app')


@section('custom_css')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #d98b8b;
        }
        .mejoramiento {
            background-color: green;
            color: white;
        }
        .apropiacion {
            background-color: yellow;
        }
        .existencia {
            background-color: lightgray;
        }
        .categoria {
            font-weight: bold;
            background-color: #d9a6a6;
        }
        .mejoramiento {
            background-color: green;
            color: white;
            text-align: center;
        }
    </style>
@endsection
@section('content')
 <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-header"><center><h2>PEI</h2></center></h5>
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
                                        <div class="card-body">
                                            <h5 class="card-header">
                                              <center><h3>Direccionamiento Estratégico</h3></center>
                                            </h5>
                                            <form method="post" action="#">
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Mision</label>
                                                  <textarea class="form-control" id="full-editor" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Vision</label>
                                                    <textarea class="form-control" id="full-editor2" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Principios Institucionales</label>
                                                    <textarea class="form-control" id="full-editor3" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Metas Institucionales</label>
                                                    <textarea class="form-control" id="full-editor4" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Política de inclusión</label>
                                                    <textarea class="form-control" id="full-editor5" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <br>
                                              <div class="row">
                                                <center>
                                                  <h3>Gestión Estratégica</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label"> Liderazgo y trabajo en equipo</label>
                                                    <textarea class="form-control" id="full-editor6" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Articulación de planes, proyectos y acciones</label>
                                                    <textarea class="form-control" id="full-editor7" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Seguimiento y autoevaluación</label>
                                                    <textarea class="form-control" id="full-editor8" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <center>
                                                  <h3>Gobierno Escolar</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Gobierno Escolar</label>
                                                    <textarea class="form-control" id="full-editor9" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Anexo Gobierno Escolar(Manual de funciones GE)</label>
                                                    <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <br>
                                              <div class="row">
                                                <center>
                                                  <h3>Cultura Institucional</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Cultura Institucional</label>
                                                    <textarea class="form-control" id="full-editor10" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Anexo Cultura Institucional(Política de comunicación)</label>
                                                    <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Política de bienestar</label>
                                                    <textarea class="form-control" id="full-editor11" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Apoyo a la investigación y divulgación de buenas prácticas</label>
                                                    <textarea class="form-control" id="full-editor12" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Inventario de caracterización de buenas prácticas, con vigencia</label>
                                                    <textarea class="form-control" id="full-editor13" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <br>
                                              <div class="row">
                                                <center>
                                                  <h3>Clima Escolar</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Sentido de pertenencia y participación</label>
                                                    <textarea class="form-control" id="full-editor14" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Inducción Institucional</label>
                                                    <textarea class="form-control" id="full-editor15" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Manual de Convivencia</label>
                                                  <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Actividades extracurriculares</label>
                                                    <textarea class="form-control" id="full-editor16" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Manejo de conflictos y casos difíciles</label>
                                                    <textarea class="form-control" id="full-editor17" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <br>
                                              <div class="row">
                                                <center>
                                                  <h3>Relaciones con el Entorno</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Relación con familias y acudientes</label>
                                                    <textarea class="form-control" id="full-editor18" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Seguimiento a egresados</label>
                                                    <textarea class="form-control" id="full-editor19" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Alianzas con otras instituciones</label>
                                                  <textarea class="form-control" id="full-editor20" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Anexos Alianzas con otras instituciones</label>
                                                  <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Alianzas con el sector productivo</label>
                                                  <textarea class="form-control" id="full-editor21" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Anexos Alianzas con el sector productivo</label>
                                                  <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                </div>
                                              </div>
                                              <br>
                                              <button class="btn btn-success">Cargar</button>
                                          </form>
                                          </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-tab-gestion-academica" role="tabpanel">
                                    <div class="card-datatable table-responsive pt-0">
                                        <div class="card-body">
                                            <h5 class="card-header">
                                              <center><h3>Diseño pedagógico</h3></center>
                                            </h5>
                                            <form method="post" action="#">
                                              <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Plan de estudios</label>
                                                        <textarea class="form-control" id="full-editor22" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Enfoque metodológico</label>
                                                        <textarea class="form-control" id="full-editor23" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                    <label for="form" class="form-label">Anexo Enfoque metodológico</label>
                                                        <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Estrategia pedagógica</label>
                                                        <textarea class="form-control" id="full-editor24" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Anexo  Estrategia pedagógica</label>
                                                        <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label"> Análisis y seguimiento a la jornada escolar</label>
                                                        <textarea class="form-control" id="full-editor25" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Anexo  Análisis y seguimiento a la jornada escolar</label>
                                                        <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label"> Sistema Institucional de Evaluación de los Estudiantes (SIEE)</label>
                                                        <textarea class="form-control" id="full-editor26" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Anexo  Sistema Institucional de Evaluación de los Estudiantes (SIEE)</label>
                                                        <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </div>
                                              </div>
                                              <!--  -->
                                              <div class="row"><center><h3>Prácticas Pedagógicas</h3></center></div>
                                              <!--  -->
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Estrategias para las tareas escolares</label>
                                                    <textarea class="form-control" id="full-editor27" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <center>
                                                  <h3>Gestion de Aula</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Ambientes de aprendizaje</label>
                                                    <textarea class="form-control" id="full-editor28" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Motivación hacia el aprendizaje</label>
                                                      <textarea class="form-control" id="full-editor29" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Plan de aula, opciones didácticas y temas de enseñanza obligatoria.</label>
                                                      <textarea class="form-control" id="full-editor30" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Evaluación en el aula.</label>
                                                      <textarea class="form-control" id="full-editor31" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <center><h3>Seguimiento Académico</h3></center>
                                                </div>
                                                <div class="row">
                                                  <div class="col-sm-12 col-md-12">
                                                    <label for="form" class="form-label">Seguimiento a los desempeños de los estudiantes.</label>
                                                      <textarea class="form-control" id="full-editor32" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Anexo Seguimiento a los desempeños de los estudiantes.</label>
                                                        <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Uso pedagógico de las evaluaciones externas.</label>
                                                        <textarea class="form-control" id="full-editor33" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Apoyo pedagógico para estudiantes con dificultades de aprendizaje.</label>
                                                        <textarea class="form-control" id="full-editor34" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Control Fiscal</label>
                                                      <textarea class="form-control" id="full-editor35" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <br>
                                              <button class="btn btn-success">Cargar</button>
                                            </form>
                                          </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                    <div class="card-datatable table-responsive pt-0">
                                        <div class="card-body">
                                            <h5 class="card-header">
                                              <center><h3>Apoyo a la gestión</h3></center>
                                            </h5>
                                            <form method="post" action="#">
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Proceso de matrícula</label>
                                                  <textarea class="form-control" id="full-editor36" rows="4" type="text" name="descripcion"></textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Anexo Proceso de matrícula(Acto Administrativo)</label>
                                                    <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <label for="form" class="form-label">Sistema de información académica</label>
                                                    <textarea class="form-control" id="full-editor37" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <br>
                                              <hr>
                                              <br>
                                              <div class="row">
                                                  <center>
                                                      <h3>Administración de la planta física y de los recursos</h3>
                                                  </center>
                                              </div>
                                              <div class="row">
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label"> Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa</label>
                                                      <textarea class="form-control" id="full-editor38" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                    <label for="form" class="form-label">Anexo Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa(Política de mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa)</label>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label"> Dotación, mantenimiento y uso de recursos para el aprendizaje</label>
                                                      <textarea class="form-control" id="full-editor39" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Anexo Dotación, mantenimiento y uso de recursos para el aprendizaje(Política de dotación, mantenimiento y uso de recursos para el aprendizaje)</label>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label"> Programas de seguridad</label>
                                                      <textarea class="form-control" id="full-editor40" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <center>
                                                  <h3>Administración de los Servicios Complementarios</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Estrategias de acceso y permanencia (PAE, transporte escolar y otros)</label>
                                                    <textarea class="form-control" id="full-editor41" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <center>
                                                  <h3>Talento humano</h3>
                                                </center>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Perfiles, asignación académica y de funciones.</label>
                                                    <textarea class="form-control" id="full-editor42" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Programa de formación y capacitación institucional</label>
                                                      <textarea class="form-control" id="full-editor43" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Anexo Programa de formación y capacitación institucional</label>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                  <label for="form" class="form-label">Pertenencia del personal vinculado</label>
                                                  <textarea class="form-control" id="full-editor44" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Evaluación del desempeño de directivos, docentes  y administrativos</label>
                                                      <textarea class="form-control" id="full-editor45" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Anexo Programa de formación y capacitación institucional</label>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                  </div>
                                                  <div class="col-sm-12 col-md-12">
                                                    <label for="form" class="form-label">Convivencia y manejo de conflictos</label>
                                                    <textarea class="form-control" id="full-editor46" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <center>
                                                    <h3>Apoyo financiero y contable</h3>
                                                  </center>
                                                </div>
                                                <div class="row">
                                                  <div class="col-sm-12 col-md-12">
                                                    <label for="form" class="form-label">Presupuesto anual del Fondo de Servicios Educativos (FSE)</label>
                                                      <textarea class="form-control" id="full-editor47" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Anexo Presupuesto anual del Fondo de Servicios Educativos (FSE)</label>
                                                        <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Contabilidad</label>
                                                        <textarea class="form-control" id="full-editor48" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label for="form" class="form-label">Contratación</label>
                                                        <textarea class="form-control" id="full-editor49" rows="4" type="text" name="descripcion"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-sm-12 col-md-12">
                                                      <label for="form" class="form-label">Control Fiscal</label>
                                                      <textarea class="form-control" id="full-editor50" rows="4" type="text" name="descripcion"></textarea>
                                                  </div>
                                              </div>
                                              <br>
                                              <button class="btn btn-success">Cargar</button>
                                            </form>
                                          </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                                    <div class="card-datatable table-responsive pt-0">
                                        <div class="row">
                                            <div class="row">
                                                <center>
                                                    <h3>Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación</h3>
                                                </center>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación</label>
                                                <textarea class="form-control" id="full-editor51" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                              <label for="form" class="form-label">Necesidades y expectativas de los estudiantes</label>
                                              <textarea class="form-control" id="full-editor52" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label"> Proyectos de vida</label>
                                                <textarea class="form-control" id="full-editor53" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Escuela de padres</label>
                                                <textarea class="form-control" id="full-editor54" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Oferta de servicios a la comunidad</label>
                                                <textarea class="form-control" id="full-editor55" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Programa de servicio social institucional</label>
                                                <textarea class="form-control" id="full-editor56" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Anexo Programa de servicio social institucional</label>
                                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Prevención de riesgos físicos</label>
                                                <textarea class="form-control" id="full-editor57" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Anexo Prevención de riesgos físicos</label>
                                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <label for="form" class="form-label">Prevención de riesgos psicosociales</label>
                                                <textarea class="form-control" id="full-editor58" rows="4" type="text" name="descripcion"></textarea>
                                            </div>
                                        </div>
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

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://pixinvent.com" target="_blank" class="footer-link fw-semibold">PIXINVENT</a>
                </div>
                <div>
                  <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank"
                    >License</a
                  >
                  <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4"
                    >More Themes</a
                  >

                  <a
                    href="https://pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/documentation-bs5/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
@endsection
