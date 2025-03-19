@extends('layouts.app')

@section('content')
 <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 breadcrumb-wrapper mb-4">MATRIZ DE FORTALEZAS Y DEBILIDADES </h4>

              <div class="row">
                <!-- Snow Theme -->
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-header">
                            <center><h3>MATRIZ DE FORTALEZAS Y DEBILIDADES  Institucion XXXXXXXXXXX</h3></center>
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
                                            <table border="1" style="border-collapse: collapse; text-align: center; width: 100%; font-family: Arial, sans-serif;">
                                                <thead style="background-color: #444; color: white;">
                                                    <tr>
                                                        <th>GESTIÓN</th>
                                                        <th>FORTALEZAS</th>
                                                        <th>OPORTUNIDADES DE MEJORAMIENTO</th>
                                                        <th>FACTORES CRÍTICOS</th>
                                                        <th>VALORACIÓN</th>
                                                        <th>IMPACTO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="5" style="background-color: #800000; color: white;" >DIRECTIVA</td>
                                                        <td>
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            -Proceso 1
                                                            -Proceso 2
                                                            -Proceso 3
                                                        </td>
                                                        <td>lo que se requiere para mejorar es prioritacio para le funcionamiento</td>
                                                        <td>1</td>
                                                        <td>Menor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>- Factor 1
                                                            - Factor 2
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ninguna</td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-tab-gestion-academica" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table border="1" style="border-collapse: collapse; text-align: center; width: 100%; font-family: Arial, sans-serif;">
                                                <thead style="background-color: #444; color: white;">
                                                    <tr>
                                                        <th>GESTIÓN</th>
                                                        <th>FORTALEZAS</th>
                                                        <th>OPORTUNIDADES DE MEJORAMIENTO</th>
                                                        <th>FACTORES CRÍTICOS</th>
                                                        <th>VALORACIÓN</th>
                                                        <th>IMPACTO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color: #28734A; color: white;" rowspan="5">ACADÉMICA</td>
                                                        <td>
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            -Proceso 1
                                                            -Proceso 2
                                                            -Proceso 3
                                                        </td>
                                                        <td>lo que se requiere para mejorar es prioritacio para le funcionamiento</td>
                                                        <td>1</td>
                                                        <td>Menor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>- Factor 1
                                                            - Factor 2
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ninguna</td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-tab-gestion-administrativa" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table border="1" style="border-collapse: collapse; text-align: center; width: 100%; font-family: Arial, sans-serif;">
                                                <thead style="background-color: #444; color: white;">
                                                    <tr>
                                                        <th>GESTIÓN</th>
                                                        <th>FORTALEZAS</th>
                                                        <th>OPORTUNIDADES DE MEJORAMIENTO</th>
                                                        <th>FACTORES CRÍTICOS</th>
                                                        <th>VALORACIÓN</th>
                                                        <th>IMPACTO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color: #006400; color: white;" rowspan="5">ADMINISTRATIVA Y FINANCIERA</td>
                                                        <td>
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            -Proceso 1
                                                            -Proceso 2
                                                            -Proceso 3
                                                        </td>
                                                        <td>lo que se requiere para mejorar es prioritacio para le funcionamiento</td>
                                                        <td>1</td>
                                                        <td>Menor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>- Factor 1
                                                            - Factor 2
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ninguna</td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table border="1" style="border-collapse: collapse; text-align: center; width: 100%; font-family: Arial, sans-serif;">
                                                <thead style="background-color: #444; color: white;">
                                                    <tr>
                                                        <th>GESTIÓN</th>
                                                        <th>FORTALEZAS</th>
                                                        <th>OPORTUNIDADES DE MEJORAMIENTO</th>
                                                        <th>FACTORES CRÍTICOS</th>
                                                        <th>VALORACIÓN</th>
                                                        <th>IMPACTO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color: #8B4513; color: white;" rowspan="5">DE LA COMUNIDAD</td>
                                                        <td>
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            -Proceso 1
                                                            -Proceso 2
                                                            -Proceso 3
                                                        </td>
                                                        <td>lo que se requiere para mejorar es prioritacio para le funcionamiento</td>
                                                        <td>1</td>
                                                        <td>Menor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>- Factor 1
                                                            - Factor 2
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                            - Factor 3
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            - Factor 1
                                                        </td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ninguna</td>
                                                        <td>
                                                            - suministros <br>
                                                            - equipos de computo <br>
                                                            - mobiliario
                                                        </td>
                                                        <td>
                                                            -carencia de documentation <br>
                                                            -carencia de ACTIVIDADES <br>
                                                            -carencia de recursos
                                                        </td>
                                                        <td>4</td>
                                                        <td style="background-color: #800000; color: white;">Mayor Impacto</td>
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
            <div class="content-backdrop fade"></div>
          </div>
@endsection
