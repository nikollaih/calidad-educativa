import { useState } from 'preact/hooks';

function VerGestionComunidad() {
  const [formData, setFormData] = useState({
    atencion_grupos_vulnerabilidad: '',
    necesidades_expectativas_estudiantes: '',
    proyectos_vida: '',
    escuela_padres: '',
    oferta_servicios_comunidad: '',
    programa_servicio_social: '',
    prevencion_riesgos_fisicos: '',
    prevencion_riesgos_psicosociales: '',
    anexo_proyecto_escuela_padres: null,
    anexo_programa_servicio_social: null,
    anexo_prevencion_riesgos_fisicos: null,
  });

  const handleChange = (e) => {
    const { name, value, type, files } = e.target;
    setFormData({
      ...formData,
      [name]: type === 'file' ? files[0] : value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    // Submit form data logic goes here
  };

  return (
    <div class="content-wrapper">
      <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-header">
                  <center>
                    <h2>FORMULARIOS DE GESTION DE PEI</h2>
                  </center>
                </h5>
                <div class="col-md-12">
                  <div class="card text-center mb-3">
                    <div class="card-header border-bottom">
                      <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-directiva" aria-controls="navs-tab-gestion-directiva" aria-selected="true">
                            1. GESTIÓN DIRECTIVA
                          </button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-academica" aria-controls="navs-tab-gestion-academica" aria-selected="true">
                            2. GESTIÓN ACADEMICA
                          </button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-administrativa" aria-controls="navs-tab-gestion-administrativa" aria-selected="true">
                            3. GESTIÓN ADMINISTRATIVA Y FINANCIERA
                          </button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-gestion-comunidad" aria-controls="navs-tab-gestion-comunidad" aria-selected="true">
                            4. GESTIÓN DE LA COMUNIDAD
                          </button>
                        </li>
                      </ul>
                    </div>
                    <div class="tab-content">
                      <div class="tab-pane fade" id="navs-tab-gestion-comunidad" role="tabpanel">
                        <div class="card-datatable table-responsive pt-0">
                          <div class="row">
                            <div class="col-12">
                              <div class="card mb-4">
                                <div class="card-body">
                                  <form onSubmit={handleSubmit} encType="multipart/form-data">
                                    <div class="accordion" id="comunidadAccordion">
                                      {/* Atención educativa a grupos poblacionales */}
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="comunidadHeadingOne">
                                          <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#comunidadCollapseOne"
                                            aria-expanded="false"
                                            aria-controls="comunidadCollapseOne"
                                          >
                                            <span class="fw-bold fs-4">Atención educativa a grupos poblacionales o en situación de vulnerabilidad</span>
                                          </button>
                                        </h2>
                                        <div id="comunidadCollapseOne" class="accordion-collapse collapse" aria-labelledby="comunidadHeadingOne" data-bs-parent="#comunidadAccordion">
                                          <div class="accordion-body">
                                            <div class="row mb-3">
                                              <div class="col-12">
                                                <label class="form-label">Atención educativa a grupos poblacionales o en situación de vulnerabilidad</label>
                                                <textarea
                                                  class="form-control"
                                                  id="comunidad-editor1"
                                                  rows="3"
                                                  name="atencion_grupos_vulnerabilidad"
                                                  value={formData.atencion_grupos_vulnerabilidad}
                                                  onChange={handleChange}
                                                ></textarea>
                                              </div>
                                            </div>
                                            <div class="row mb-3">
                                              <div class="col-12">
                                                <label class="form-label">Necesidades y expectativas de los estudiantes</label>
                                                <textarea
                                                  class="form-control"
                                                  id="comunidad-editor2"
                                                  rows="3"
                                                  name="necesidades_expectativas_estudiantes"
                                                  value={formData.necesidades_expectativas_estudiantes}
                                                  onChange={handleChange}
                                                ></textarea>
                                              </div>
                                            </div>
                                            <div class="row mb-3">
                                              <div class="col-12">
                                                <label class="form-label">Proyectos de vida</label>
                                                <textarea
                                                  class="form-control"
                                                  id="comunidad-editor3"
                                                  rows="3"
                                                  name="proyectos_vida"
                                                  value={formData.proyectos_vida}
                                                  onChange={handleChange}
                                                ></textarea>
                                              </div>
                                            </div>
                                            <div class="row mb-3">
                                              <div class="col-12">
                                                <label class="form-label">Escuela de padres</label>
                                                <textarea
                                                  class="form-control"
                                                  id="comunidad-editor4"
                                                  rows="3"
                                                  name="escuela_padres"
                                                  value={formData.escuela_padres}
                                                  onChange={handleChange}
                                                ></textarea>
                                              </div>
                                            </div>
                                            <div class="row">
                                              <label class="form-label">Anexo, Proyecto escuela de padres</label>
                                              <div class="col-12 d-flex gap-2 justify-content-between align-items-center">
                                                {/* Attachments */}
                                                <input
                                                  type="file"
                                                  name="anexo_proyecto_escuela_padres"
                                                  class="form-control"
                                                  accept="application/pdf"
                                                  onChange={handleChange}
                                                />
                                              </div>
                                            </div>
                                            <div class="row mb-3">
                                              <div class="col-12">
                                                <label class="form-label">Oferta de servicios a la comunidad</label>
                                                <textarea
                                                  class="form-control"
                                                  id="comunidad-editor5"
                                                  rows="3"
                                                  name="oferta_servicios_comunidad"
                                                  value={formData.oferta_servicios_comunidad}
                                                  onChange={handleChange}
                                                ></textarea>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      {/* Other Accordion Items (Programas, Prevención, etc.) */}
                                    </div>

                                    <div class="text-center mt-4">
                                      <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bx bx-save me-1"></i> Guardar Todo
                                      </button>
                                    </div>
                                  </form>
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
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default VerGestionComunidad;
