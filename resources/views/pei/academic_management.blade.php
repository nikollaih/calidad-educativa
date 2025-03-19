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
                        <center><h3>Apoyo a la gestión académica</h3></center>
                      </h5>
                      <form method="post" action="#">
                        <div class="row">
                          <div class="col-sm-12 col-md-12">
                            <label for="form" class="form-label">Proceso de matrícula</label>
                            <textarea class="form-control" id="full-editor" rows="4" type="text" name="descripcion"></textarea>
                          </div>
                          <div class="col-sm-12 col-md-12">
                            <label for="form" class="form-label">Anexo Proceso de matrícula(Acto Administrativo)</label>
                              <input class="form-control" rows="4" type="file" name="descripcion"></input>
                          </div>
                          <div class="col-sm-12 col-md-12">
                              <label for="form" class="form-label">Sistema de información académica</label>
                              <textarea class="form-control" id="full-editor2" rows="4" type="text" name="descripcion"></textarea>
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
                                <textarea class="form-control" id="full-editor3" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                              <label for="form" class="form-label">Anexo Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa(Política de mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa)</label>
                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label"> Dotación, mantenimiento y uso de recursos para el aprendizaje</label>
                                <textarea class="form-control" id="full-editor5" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Anexo Dotación, mantenimiento y uso de recursos para el aprendizaje(Política de dotación, mantenimiento y uso de recursos para el aprendizaje)</label>
                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label"> Programas de seguridad</label>
                                <textarea class="form-control" id="full-editor6" rows="4" type="text" name="descripcion"></textarea>
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
                              <textarea class="form-control" id="full-editor7" rows="4" type="text" name="descripcion"></textarea>
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
                              <textarea class="form-control" id="full-editor8" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Programa de formación y capacitación institucional</label>
                                <textarea class="form-control" id="full-editor9" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Anexo Programa de formación y capacitación institucional</label>
                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-md-12">
                            <label for="form" class="form-label">Pertenencia del personal vinculado</label>
                            <textarea class="form-control" id="full-editor10" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Evaluación del desempeño de directivos, docentes  y administrativos</label>
                                <textarea class="form-control" id="full-editor11" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Anexo Programa de formación y capacitación institucional</label>
                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                            </div>
                            <div class="col-sm-12 col-md-12">
                              <label for="form" class="form-label">Convivencia y manejo de conflictos</label>
                              <textarea class="form-control" id="full-editor12" rows="4" type="text" name="descripcion"></textarea>
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
                                <textarea class="form-control" id="full-editor13" rows="4" type="text" name="descripcion"></textarea>
                              </div>
                              <div class="col-sm-12 col-md-12">
                                  <label for="form" class="form-label">Anexo Presupuesto anual del Fondo de Servicios Educativos (FSE)</label>
                                  <input class="form-control" rows="4" type="file" name="descripcion"></input>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-12 col-md-12">
                                  <label for="form" class="form-label">Contabilidad</label>
                                  <textarea class="form-control" id="full-editor14" rows="4" type="text" name="descripcion"></textarea>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-12 col-md-12">
                                  <label for="form" class="form-label">Contratacion</label>
                                  <textarea class="form-control" id="full-editor15" rows="4" type="text" name="descripcion"></textarea>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Control Fiscal</label>
                                <textarea class="form-control" id="full-editor16" rows="4" type="text" name="descripcion"></textarea>
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
