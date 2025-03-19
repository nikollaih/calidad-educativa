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
                      <!-- <h5 class="card-header">
                        <center><h3>Apoyo a la gestión académica</h3></center>
                      </h5> -->
                      <form method="post" action="#">
                        <div class="row">
                            <div class="row">
                                <center>
                                    <h3>Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación</h3>
                                </center>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación</label>
                                <textarea class="form-control" id="full-editor" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                              <label for="form" class="form-label">Necesidades y expectativas de los estudiantes</label>
                              <textarea class="form-control" id="full-editor2" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label"> Proyectos de vida</label>
                                <textarea class="form-control" id="full-editor3" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Escuela de padres</label>
                                <textarea class="form-control" id="full-editor5" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Oferta de servicios a la comunidad</label>
                                <textarea class="form-control" id="full-editor6" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Programa de servicio social institucional</label>
                                <textarea class="form-control" id="full-editor9" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Anexo Programa de servicio social institucional</label>
                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Prevención de riesgos físicos</label>
                                <textarea class="form-control" id="full-editor11" rows="4" type="text" name="descripcion"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Anexo Prevención de riesgos físicos</label>
                                <input class="form-control" rows="4" type="file" name="descripcion"></input>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="form" class="form-label">Prevención de riesgos psicosociales</label>
                                <textarea class="form-control" id="full-editor10" rows="4" type="text" name="descripcion"></textarea>
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
