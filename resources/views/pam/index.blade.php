@extends('layouts.app')

@section('content')


    <div class="content-wrapper">
            <!-- Content -->
            <div class="container-fluid flex-grow-1 container-p-y">
              <div class="row">
                <!-- Snow Theme -->
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-body">
                      <h5 class="card-header">
                        <center><h3>Plan de Apoyo al Mejoramiento</h3></center>
                    </h5>
                    <div class="row">
                      <div class="col-md-3">
                        <label for="form" class="form-label">Consecutivo PAM</label>
                        <input class="form-control" type="text" name="" value="00342" readonly></input>
                      </div>
                      <div class="col-md-3">
                        <label for="form" class="form-label">Fecha Elaboracion PAM</label>
                        <input class="form-control" type="date" name="" value=""></input>
                      </div>
                      <div class="col-md-4">
                        <label for="form" class="form-label">Institucion</label>
                        <select class="form-control" name="valoracion" id="valoracion">
                            <option value="1" selected>Institucion Educativa General Santander</option>
                            <option value="1">Instituto Montenegro</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                      <div class="card text-center mb-3">
                          <div class="card-header border-bottom">
                              <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-directiva" aria-controls="navs-tab-gestion-directiva" aria-selected="true">ACOMPAÑAMIENTO</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-academica" aria-controls="navs-tab-gestion-academica" aria-selected="true">FORMACION</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-administrativa" aria-controls="navs-tab-gestion-administrativa" aria-selected="true">DESARROLLO</button>
                                </li>
                              </ul>
                          </div>
                          <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-tab-gestion-directiva" role="tabpanel">
                                <div class="card-datatable table-responsive pt-0">
                                    <h5 class="card-header">
                                      <center><h3>ACOMPAÑAMIENTO A LOS ESTABLECIMIENTOS EDUCATIVOS</h3></center>
                                  </h5>
                                  <div class="row">
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label">Ubicación Geográfica</label>
                                          <input class="form-control" type="text" name=""></input>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                        <label for="form" class="form-label">Objetivos Estratégicos</label>
                                        <textarea class="form-control" id="full-editor16" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Metas</label>
                                          <textarea class="form-control" id="full-editor3" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Indicadores</label>
                                          <textarea class="form-control" id="full-editor5" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Acciones</label>
                                          <textarea class="form-control" id="full-editor6" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label">Responsables</label>
                                          <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1" selected>responsable 1</option>
                                              <option value="2">responsable 2</option>
                                              <option value="3">responsable 3</option>
                                              <option value="4" >responsable 4</option>
                                          </select>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Recursos</label>
                                          <textarea class="form-control" id="full-editor7" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-4">
                                          <label for="form" class="form-label">Fecha Inicio Metas</label>
                                          <input class="form-control" rows="4" type="date" name=""></input>
                                      </div>
                                      <div class="col-sm-12 col-md-4">
                                          <label for="form" class="form-label">Fecha Fin Metas</label>
                                          <input class="form-control" rows="4" type="date" name=""></input>
                                      </div>
                                  </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-tab-gestion-academica" role="tabpanel">
                                <div class="card-datatable table-responsive pt-0">
                                    <h5 class="card-header">
                                      <center><h3>FORMACION DE DOCENTES Y DIRECTIVOS DOCENTES</h3></center>
                                    </h5>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <label for="form" class="form-label">Ubicación Geográfica</label>
                                            <input class="form-control" type="text" name=""></input>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                        <label for="form" class="form-label">Objetivos Estratégicos</label>
                                        <textarea class="form-control" id="full-editor2" rows="4" type="text" name="descripcion"></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <label for="form" class="form-label"> Metas</label>
                                            <textarea class="form-control" id="full-editor8" rows="4" type="text" name="descripcion"></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <label for="form" class="form-label"> Indicadores</label>
                                            <textarea class="form-control" id="full-editor9" rows="4" type="text" name="descripcion"></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <label for="form" class="form-label"> Acciones</label>
                                            <textarea class="form-control" id="full-editor10" rows="4" type="text" name="descripcion"></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <label for="form" class="form-label">Responsables</label>
                                            <select class="form-control" name="valoracion" id="valoracion">
                                                <option value="1" selected>responsable 1</option>
                                                <option value="2">responsable 2</option>
                                                <option value="3">responsable 3</option>
                                                <option value="4" >responsable 4</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <label for="form" class="form-label"> Recursos</label>
                                            <textarea class="form-control" id="full-editor11" rows="4" type="text" name="descripcion"></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="form" class="form-label">Fecha Inicio Metas</label>
                                            <input class="form-control" rows="4" type="date" name=""></input>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="form" class="form-label">Fecha Fin Metas</label>
                                            <input class="form-control" rows="4" type="date" name=""></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                <div class="card-datatable table-responsive pt-0">
                                  <h5 class="card-header">
                                      <center><h3>USO Y DESARROLLO DE CONTENIDOS CON APOYO DE  MTIC</h3></center>
                                  </h5>
                                  <div class="row">
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label">Ubicación Geográfica</label>
                                          <input class="form-control" type="text" name=""></input>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label">Objetivos Estratégicos</label>
                                          <textarea class="form-control" id="full-editor15" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Metas</label>
                                          <textarea class="form-control" id="full-editor12" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Indicadores</label>
                                          <textarea class="form-control" id="full-editor13" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Acciones</label>
                                          <textarea class="form-control" id="full-editor14" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label">Responsables</label>
                                          <select class="form-control" name="valoracion" id="valoracion">
                                              <option value="1" selected>responsable 1</option>
                                              <option value="2">responsable 2</option>
                                              <option value="3">responsable 3</option>
                                              <option value="4" >responsable 4</option>
                                          </select>
                                      </div>
                                      <div class="col-sm-12 col-md-12">
                                          <label for="form" class="form-label"> Recursos</label>
                                          <textarea class="form-control" id="full-editor16" rows="4" type="text" name="descripcion"></textarea>
                                      </div>
                                      <div class="col-sm-12 col-md-4">
                                          <label for="form" class="form-label">Fecha Inicio Metas</label>
                                          <input class="form-control" rows="4" type="date" name=""></input>
                                      </div>
                                      <div class="col-sm-12 col-md-4">
                                          <label for="form" class="form-label">Fecha Fin Metas</label>
                                          <input class="form-control" rows="4" type="date" name=""></input>
                                      </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        <button class="btn btn-success">Cargar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          </div>

@endsection
