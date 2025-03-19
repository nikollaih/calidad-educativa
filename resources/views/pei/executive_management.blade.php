@extends('layouts.app')

@section('content')

              <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <!-- Snow Theme -->
                <div class="col-12">
                  <div class="card mb-4">
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
                <!-- /Snow Theme -->
                <!-- Bubble Theme -->
                <!-- <div class="col-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Bubble Theme</h5>
                    <div class="card-body">
                      <div id="bubble-toolbar">
                        <span class="ql-formats">
                          <select class="ql-font"></select>
                          <select class="ql-size"></select>
                        </span>
                        <span class="ql-formats">
                          <button class="ql-bold"></button>
                          <button class="ql-italic"></button>
                          <button class="ql-underline"></button>
                          <button class="ql-strike"></button>
                        </span>
                        <span class="ql-formats">
                          <select class="ql-color"></select>
                          <select class="ql-background"></select>
                        </span>
                        <span class="ql-formats">
                          <button class="ql-script" value="sub"></button>
                          <button class="ql-script" value="super"></button>
                        </span>
                        <span class="ql-formats">
                          <button class="ql-header" value="1"></button>
                          <button class="ql-header" value="2"></button>
                          <button class="ql-blockquote"></button>
                          <button class="ql-code-block"></button>
                        </span>
                      </div>
                      <div id="bubble-editor">
                        <h6>Quill Rich Text Editor</h6>
                        <p>
                          Cupcake ipsum dolor sit amet. Halvah cheesecake chocolate bar gummi bears cupcake. Pie
                          macaroon bear claw. Soufflé I love candy canes I love cotton candy I love.
                        </p>
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- /Bubble Theme -->
                <!-- Full Editor -->
                <!-- <div class="col-12">
                  <div class="card">
                    <h5 class="card-header">Full Editor</h5>
                    <div class="card-body">
                      <div id="full-editor">
                        <h6>Quill Rich Text Editor</h6>
                        <p>
                          Cupcake ipsum dolor sit amet. Halvah cheesecake chocolate bar gummi bears cupcake. Pie
                          macaroon bear claw. Soufflé I love candy canes I love cotton candy I love.
                        </p>
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- /Full Editor -->
              </div>
            </div>
            <!-- / Content -->

@endsection
