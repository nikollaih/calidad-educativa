@extends('layouts.app')

@section('content')
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 breadcrumb-wrapper mb-4"> Plan de Mejoramiento Institucional</h4>

              <div class="row">
                <!-- Snow Theme -->
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-header">
                            <center><h3>Plan de Mejoramiento Institucional Institucion XXXXXXXXXXX</h3></center>
                        </h5>
                        <div class="col-md-12">
                            <div class="card text-center mb-3">
                                <div class="card-header border-bottom">
                                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                      <li class="nav-item">
                                          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-directiva" aria-controls="navs-tab-gestion-directiva" aria-selected="true">GESTIÓN DIRECTIVA</button>
                                      </li>
                                      <li class="nav-item">
                                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-academica" aria-controls="navs-tab-gestion-academica" aria-selected="true">GESTIÓN ACADEMICA</button>
                                      </li>
                                      <li class="nav-item">
                                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-administrativa" aria-controls="navs-tab-gestion-administrativa" aria-selected="true">GESTIÓN ADMINISTRATIVA Y FINANCIERA</button>
                                      </li>
                                      <li class="nav-item">
                                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"data-bs-target="#navs-tab-gestion-comunidad" aria-controls="navs-tab-gestion-comunidad" aria-selected="true">GESTIÓN DE LA COMUNIDAD</button>
                                      </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-tab-gestion-directiva" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table width="100%;">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">PROCESO</th>
                                                        <th rowspan="2">COMPONENTE</th>
                                                        <th rowspan="2">FACTORES CRÍTICOS</th>
                                                        <th rowspan="2">OBJETIVOS</th>
                                                        <th rowspan="2">INDICADORES</th>
                                                        <th rowspan="2">ACTIVIDADES</th>
                                                        <th rowspan="2">EVIDENCIAS</th>
                                                        <th rowspan="2">RESPONSABLE</th>
                                                        <th colspan="12">PLAZO</th>
                                                        <th colspan="12">SEGUIMIENTO</th>
                                                        <th rowspan="2">OBSERVACIONES</th>
                                                    </tr>
                                                    <tr>
                                                        <th>E</th><th>F</th><th>M</th><th>A</th><th>M</th><th>J</th><th>J</th><th>A</th><th>S</th><th>O</th><th>N</th><th>D</th>
                                                        <th>E</th><th>F</th><th>M</th><th>A</th><th>M</th><th>J</th><th>J</th><th>A</th><th>S</th><th>O</th><th>N</th><th>D</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="1">Direccionamiento estratégico</td>
                                                        <td rowspan="1">Socialización de temas familiares</td>
                                                        <td class="factores-criticos">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Factor Critico 1</option>
                                                            <option value="2">Factor Critico 2</option>
                                                            <option value="3">Factor Critico 3</option>
                                                            <option value="4" >Factor Critico 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Objetivo 1</option>
                                                            <option value="2">Objetivo 2</option>
                                                            <option value="3">Objetivo 3</option>
                                                            <option value="4" >Objetivo 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Indicador 1</option>
                                                            <option value="2">Indicador 2</option>
                                                            <option value="3">Indicador 3</option>
                                                            <option value="4">Indicador 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Actividad 1</option>
                                                            <option value="2">Actividad 2</option>
                                                            <option value="3">Actividad 3</option>
                                                            <option value="4">Actividad 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                        </td>
                                                        <td>Armando Casas</td>
                                                        <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                        <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gestión Estratégica</td>
                                                        <td>Socialización de temas</td>
                                                        <td class="factores-criticos">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Factor Critico 1</option>
                                                            <option value="2">Factor Critico 2</option>
                                                            <option value="3">Factor Critico 3</option>
                                                            <option value="4" >Factor Critico 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Objetivo 1</option>
                                                            <option value="2">Objetivo 2</option>
                                                            <option value="3">Objetivo 3</option>
                                                            <option value="4" >Objetivo 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Indicador 1</option>
                                                            <option value="2">Indicador 2</option>
                                                            <option value="3">Indicador 3</option>
                                                            <option value="4">Indicador 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Actividad 1</option>
                                                            <option value="2">Actividad 2</option>
                                                            <option value="3">Actividad 3</option>
                                                            <option value="4">Actividad 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                        </td>
                                                        <td>Armando Casas</td>
                                                        <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                        <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gobierno Escolar</td>
                                                        <td>Socialización de temas familiares</td>
                                                        <td class="factores-criticos">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Factor Critico 1</option>
                                                            <option value="2">Factor Critico 2</option>
                                                            <option value="3">Factor Critico 3</option>
                                                            <option value="4" >Factor Critico 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Objetivo 1</option>
                                                            <option value="2">Objetivo 2</option>
                                                            <option value="3">Objetivo 3</option>
                                                            <option value="4" >Objetivo 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Indicador 1</option>
                                                            <option value="2">Indicador 2</option>
                                                            <option value="3">Indicador 3</option>
                                                            <option value="4">Indicador 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Actividad 1</option>
                                                            <option value="2">Actividad 2</option>
                                                            <option value="3">Actividad 3</option>
                                                            <option value="4">Actividad 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                        </td>
                                                        <td>Armando Casas</td>
                                                        <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                        <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Direccionamiento estratégico</td>
                                                        <td>Socialización de temas familiares</td>
                                                        <td class="factores-criticos">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Factor Critico 1</option>
                                                            <option value="2">Factor Critico 2</option>
                                                            <option value="3">Factor Critico 3</option>
                                                            <option value="4" >Factor Critico 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Objetivo 1</option>
                                                            <option value="2">Objetivo 2</option>
                                                            <option value="3">Objetivo 3</option>
                                                            <option value="4" >Objetivo 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Indicador 1</option>
                                                            <option value="2">Indicador 2</option>
                                                            <option value="3">Indicador 3</option>
                                                            <option value="4">Indicador 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <select class="form-control" name="valoracion" id="valoracion">
                                                            <option value="1" selected>Actividad 1</option>
                                                            <option value="2">Actividad 2</option>
                                                            <option value="3">Actividad 3</option>
                                                            <option value="4">Actividad 4</option>
                                                          </select>
                                                        </td>
                                                        <td class="">
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                          <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                        </td>
                                                        <td>Armando Casas</td>
                                                        <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                        <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-tab-gestion-academica" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                          <table width="100%;">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">PROCESO</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">COMPONENTE</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">FACTORES CRÍTICOS</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">OBJETIVOS</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">INDICADORES</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">ACTIVIDADES</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">EVIDENCIAS</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">RESPONSABLE</th>
                                                    <th style="background-color: #1cd347 !important;" colspan="12">PLAZO</th>
                                                    <th style="background-color: #1cd347 !important;" colspan="12">SEGUIMIENTO</th>
                                                    <th style="background-color: #1cd347 !important;" rowspan="2">OBSERVACIONES</th>
                                                </tr>
                                                <tr>
                                                    <th style="background-color: #1cd347 !important;">E</th><th style="background-color: #1cd347 !important;">F</th><th style="background-color: #1cd347 !important;">M</th><th style="background-color: #1cd347 !important;">A</th><th style="background-color: #1cd347 !important;">M</th><th style="background-color: #1cd347 !important;">J</th><th style="background-color: #1cd347 !important;">J</th><th style="background-color: #1cd347 !important;">A</th><th style="background-color: #1cd347 !important;">S</th><th style="background-color: #1cd347 !important;">O</th><th style="background-color: #1cd347 !important;">N</th><th style="background-color: #1cd347 !important;">D</th>
                                                    <th style="background-color: #1cd347 !important;">E</th><th style="background-color: #1cd347 !important;">F</th><th style="background-color: #1cd347 !important;">M</th><th style="background-color: #1cd347 !important;">A</th><th style="background-color: #1cd347 !important;">M</th><th style="background-color: #1cd347 !important;">J</th><th style="background-color: #1cd347 !important;">J</th><th style="background-color: #1cd347 !important;">A</th><th style="background-color: #1cd347 !important;">S</th><th style="background-color: #1cd347 !important;">O</th><th style="background-color: #1cd347 !important;">N</th><th style="background-color: #1cd347 !important;">D</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td rowspan="1">Diseño pedagogico</td>
                                                    <td rowspan="1">Plan de estudios</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Practicas Pedagogicas</td>
                                                    <td>Estrategias para las tareas escolares</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Gestón de Aula</td>
                                                    <td>Ambientes de aprendizaje</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Seguimiento academico</td>
                                                    <td>Seguimiento a los desempeños de los estudiantes</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                          <table width="100%;">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">PROCESO</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">COMPONENTE</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">FACTORES CRÍTICOS</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">OBJETIVOS</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">INDICADORES</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">ACTIVIDADES</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">EVIDENCIAS</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">RESPONSABLE</th>
                                                    <th style="background-color: #063a0b !important;" colspan="12">PLAZO</th>
                                                    <th style="background-color: #063a0b !important;" colspan="12">SEGUIMIENTO</th>
                                                    <th style="background-color: #063a0b !important;" rowspan="2">OBSERVACIONES</th>
                                                </tr>
                                                <tr>
                                                    <th style="background-color: #063a0b !important;">E</th><th style="background-color: #063a0b !important;">F</th><th style="background-color: #063a0b !important;">M</th><th style="background-color: #063a0b !important;">A</th><th style="background-color: #063a0b !important;">M</th><th style="background-color: #063a0b !important;">J</th><th style="background-color: #063a0b !important;">J</th><th style="background-color: #063a0b !important;">A</th><th style="background-color: #063a0b !important;">S</th><th style="background-color: #063a0b !important;">O</th><th style="background-color: #063a0b !important;">N</th><th style="background-color: #063a0b !important;">D</th>
                                                    <th style="background-color: #063a0b !important;">E</th><th style="background-color: #063a0b !important;">F</th><th style="background-color: #063a0b !important;">M</th><th style="background-color: #063a0b !important;">A</th><th style="background-color: #063a0b !important;">M</th><th style="background-color: #063a0b !important;">J</th><th style="background-color: #063a0b !important;">J</th><th style="background-color: #063a0b !important;">A</th><th style="background-color: #063a0b !important;">S</th><th style="background-color: #063a0b !important;">O</th><th style="background-color: #063a0b !important;">N</th><th style="background-color: #063a0b !important;">D</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td rowspan="1">Apoyo a la gestión académica</td>
                                                    <td rowspan="1">Proceso de matrícula</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Administración de la planta física y de los recursos</td>
                                                    <td>Mantenimiento, adecuación, embellecimiento y uso de la infraestructura educativa</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Administración de los Servicios Complementarios</td>
                                                    <td>Estrategias de acceso y permanencia (PAE, transporte escolar y otros).</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Talento humano</td>
                                                    <td>Perfiles, asignación académica y de funciones</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                          <table width="100%;">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">PROCESO</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">COMPONENTE</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">FACTORES CRÍTICOS</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">OBJETIVOS</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">INDICADORES</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">ACTIVIDADES</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">EVIDENCIAS</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">RESPONSABLE</th>
                                                    <th style="background-color: #3a1d06 !important;" colspan="12">PLAZO</th>
                                                    <th style="background-color: #3a1d06 !important;" colspan="12">SEGUIMIENTO</th>
                                                    <th style="background-color: #3a1d06 !important;" rowspan="2">OBSERVACIONES</th>
                                                </tr>
                                                <tr>
                                                    <th style="background-color: #3a1d06 !important;">E</th><th style="background-color: #3a1d06 !important;">F</th><th style="background-color: #3a1d06 !important;">M</th><th style="background-color: #3a1d06 !important;">A</th><th style="background-color: #3a1d06 !important;">M</th><th style="background-color: #3a1d06 !important;">J</th><th style="background-color: #3a1d06 !important;">J</th><th style="background-color: #3a1d06 !important;">A</th><th style="background-color: #3a1d06 !important;">S</th><th style="background-color: #3a1d06 !important;">O</th><th style="background-color: #3a1d06 !important;">N</th><th style="background-color: #3a1d06 !important;">D</th>
                                                    <th style="background-color: #3a1d06 !important;">E</th><th style="background-color: #3a1d06 !important;">F</th><th style="background-color: #3a1d06 !important;">M</th><th style="background-color: #3a1d06 !important;">A</th><th style="background-color: #3a1d06 !important;">M</th><th style="background-color: #3a1d06 !important;">J</th><th style="background-color: #3a1d06 !important;">J</th><th style="background-color: #3a1d06 !important;">A</th><th style="background-color: #3a1d06 !important;">S</th><th style="background-color: #3a1d06 !important;">O</th><th style="background-color: #3a1d06 !important;">N</th><th style="background-color: #3a1d06 !important;">D</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td rowspan="1">Accesibilidad</td>
                                                    <td rowspan="1">Atención educativa a grupos poblacionales o en situación de vulnerabilidad que experimentan barreras en el aprendizaje y la participación</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Proyección a la comunidad</td>
                                                    <td>Escuela de padres</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Prevencion de riesgos</td>
                                                    <td>Socialización de temas familiares</td>
                                                    <td class="factores-criticos">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Factor Critico 1</option>
                                                        <option value="2">Factor Critico 2</option>
                                                        <option value="3">Factor Critico 3</option>
                                                        <option value="4" >Factor Critico 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Objetivo 1</option>
                                                        <option value="2">Objetivo 2</option>
                                                        <option value="3">Objetivo 3</option>
                                                        <option value="4" >Objetivo 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Indicador 1</option>
                                                        <option value="2">Indicador 2</option>
                                                        <option value="3">Indicador 3</option>
                                                        <option value="4">Indicador 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <select class="form-control" name="valoracion" id="valoracion">
                                                        <option value="1" selected>Actividad 1</option>
                                                        <option value="2">Actividad 2</option>
                                                        <option value="3">Actividad 3</option>
                                                        <option value="4">Actividad 4</option>
                                                      </select>
                                                    </td>
                                                    <td class="">
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                      <input class="form-control" rows="4" type="file" name="descripcion"></input>
                                                    </td>
                                                    <td>Armando Casas</td>
                                                    <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                                    <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection
