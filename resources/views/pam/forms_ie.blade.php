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
                        <center><h3>Plan de Mejoramiento Institucional Institucion XXXXXXXXXXX</h3></center>
                      </h5>
                        <table>
                          <thead>
                              <tr>
                                  <th rowspan="2">ÁREA DE GESTIÓN</th>
                                  <th rowspan="2">PROCESO</th>
                                  <th rowspan="2">COMPONENTE</th>
                                  <th rowspan="2">FACTORES CRÍTICOS</th>
                                  <th rowspan="2">RESPONSABLE</th>
                                  <th colspan="12">PLAZO</th>
                                  <th colspan="12">SEGUIMIENTO</th>
                              </tr>
                              <tr>
                                  <th>E</th><th>F</th><th>M</th><th>A</th><th>M</th><th>J</th><th>J</th><th>A</th><th>S</th><th>O</th><th>N</th><th>D</th>
                                  <th>E</th><th>F</th><th>M</th><th>A</th><th>M</th><th>J</th><th>J</th><th>A</th><th>S</th><th>O</th><th>N</th><th>D</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td class="area-gestion directiva" rowspan="1">DIRECTIVA</td>
                                  <td rowspan="1">Direccionamiento estratégico</td>
                                  <td rowspan="1">Socialización de temas familiares</td>
                                  <td class="factores-criticos">Se le da a conocer en detalle la falta de ese elemento, lo que se va a priorizar si está en 1 - 2</td>
                                  <td>Persona responsable</td>
                                  <td class="plazo">1</td><td class="plazo">1</td><td class="plazo">2</td><td class="plazo">3</td><td class="plazo">3</td><td class="plazo">4</td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td><td class="plazo"></td>
                                  <td class="seguimiento">2</td><td class="seguimiento">1</td><td class="seguimiento">1</td><td class="seguimiento">3</td><td class="seguimiento">3</td><td class="seguimiento">4</td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td><td class="seguimiento"></td>
                              </tr>
                              <tr>
                                  <td class="area-gestion academica">ACADÉMICA</td>
                                  <td>Direccionamiento estratégico</td>
                                  <td>Socialización de temas familiares</td>
                                  <td class="factores-criticos">Se le da a conocer en detalle la falta de ese elemento, lo que se va a priorizar si está en 1 - 2</td>
                                  <td></td>
                                  <td colspan="12"></td>
                                  <td colspan="12"></td>
                              </tr>
                              <tr>
                                  <td class="area-gestion admin-financiera">ADMINISTRATIVA Y FINANCIERA</td>
                                  <td>Direccionamiento estratégico</td>
                                  <td>Socialización de temas familiares</td>
                                  <td class="factores-criticos">Se le da a conocer en detalle la falta de ese elemento, lo que se va a priorizar si está en 1 - 2</td>
                                  <td></td>
                                  <td colspan="12"></td>
                                  <td colspan="12"></td>
                              </tr>
                              <tr>
                                  <td class="area-gestion gestion-comunidad">GESTIÓN DE LA COMUNIDAD</td>
                                  <td>Direccionamiento estratégico</td>
                                  <td>Socialización de temas familiares</td>
                                  <td class="factores-criticos">Se le da a conocer en detalle la falta de ese elemento, lo que se va a priorizar si está en 1 - 2</td>
                                  <td></td>
                                  <td colspan="12"></td>
                                  <td colspan="12"></td>
                              </tr>
                          </tbody>
                        </table>
                      <br>
                      <hr>
                      <br>

                      <table border="1">
                        <tr>
                          <th><strong>Area de Gestion</strong></th>
                          <th><strong>Proceso</strong></th>
                          <th><strong>Componente</strong></th>
                          <th><strong>Factores Criticos</strong></th>
                          <th><strong>Objetivos</strong></th>
                          <th><strong>Indicadores</strong></th>
                          <th><strong>Actividades</strong></th>
                          <th><strong>Evidencias</strong></th>
                          <th><strong>Responsable</strong></th>
                          <th><strong>Plazo</strong></th>
                        </tr>
                        <tr>
                            <td height="100px;">DIRECTIVA</td>
                            <td height="100px;">Direcionamiento estrategico</td>
                            <td height="100px;">Misión, visión y principios, en el marco de una institución integrada</td>
                            <td height="100px;">
                                1. Factor Critico uno
                                2. Factor Critico dos
                                3. Factor Critico tres
                            </td>
                            <td height="100px;">
                                1. Objetivo uno
                                2. Objetivo dos
                                3. Objetivo tres
                            </td>
                            <td height="100px;"># de actividades a llevar a cabo: 10 </td>
                            <td height="100px;">Generacion y solcializacion de Misión, visión y principios, en el marco de una institución integrada</td>
                            <td height="100px;">
                                1. Anexo uno
                                2. Anexo dos
                                3. Anexo tres
                            </td>
                            <td height="100px;">
                                Rector de la Institucion Educativa
                            </td>
                        </tr>
                        <tr>
                            <td height="100px;">ACADEMICA</td>
                            <td height="100px;">Diseño pedagogico</td>
                            <td height="100px;">Plan de estudios</td>
                            <td height="100px;">
                                1. Factor Critico uno
                                2. Factor Critico dos
                                3. Factor Critico tres
                            </td>
                            <td height="100px;">
                                1. Objetivo uno
                                2. Objetivo dos
                                3. Objetivo tres
                            </td>
                            <td height="100px;"># de actividades a llevar a cabo: 10 </td>
                            <td height="100px;">Generacion y solcializacion de plan de estudios</td>
                            <td height="100px;">
                                1. Anexo uno
                                2. Anexo dos
                                3. Anexo tres
                            </td>
                            <td height="100px;">
                                Rector de la Institucion Educativa
                            </td>
                        </tr>
                        <tr>
                            <td height="100px;">ADMINISTRATIVA Y FINANCIERA</td>
                            <td height="100px;">Apoyo a la gestión académica</td>
                            <td height="100px;">Proceso de matrícula</td>
                            <td height="100px;">
                                1. Factor Critico uno
                                2. Factor Critico dos
                                3. Factor Critico tres
                            </td>
                            <td height="100px;">
                                1. Objetivo uno
                                2. Objetivo dos
                                3. Objetivo tres
                            </td>
                            <td height="100px;"># de actividades a llevar a cabo: 10 </td>
                            <td height="100px;">Generacion y solcializacion Proceso de matrícula</td>
                            <td height="100px;">
                                1. Anexo uno
                                2. Anexo dos
                                3. Anexo tres
                            </td>
                            <td height="100px;">
                                Rector de la Institucion Educativa
                            </td>
                        </tr>
                        <tr>
                            <td height="100px;">ACADEMICA</td>
                            <td height="100px;">Diseño pedagogico</td>
                            <td height="100px;">Plan de estudios</td>
                            <td height="100px;">
                                1. Factor Critico uno
                                2. Factor Critico dos
                                3. Factor Critico tres
                            </td>
                            <td height="100px;">
                                1. Objetivo uno
                                2. Objetivo dos
                                3. Objetivo tres
                            </td>
                            <td height="100px;"># de actividades a llevar a cabo: 10 </td>
                            <td height="100px;">Generacion y solcializacion de plan de estudios</td>
                            <td height="100px;">
                                1. Anexo uno
                                2. Anexo dos
                                3. Anexo tres
                            </td>
                            <td height="100px;">
                                Rector de la Institucion Educativa
                            </td>
                        </tr>

                      </table>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
@endsection
