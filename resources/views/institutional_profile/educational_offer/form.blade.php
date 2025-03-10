@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Editar Oferta Educativa</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('educational-offer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Modelos educativos -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modelos" class="form-label">Modelos Educativos</label>
                                <select name="modelos[]" class="form-control" multiple required>
                                    <option value="Aceleración del aprendizaje">Aceleración del aprendizaje</option>
                                    <option value="Pensar">Pensar</option>
                                    <option value="Caminar">Caminar</option>
                                    <option value="Post primaria">Post primaria</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tiene_autorizacion" class="form-label">¿Tiene autorización para validación de estudios?</label>
                                <select name="tiene_autorizacion" class="form-control" id="tiene_autorizacion" required>
                                    <option value="no">No</option>
                                    <option value="si">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="anexo_resolucion_container" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="anexo_resolucion" class="form-label">Anexo Resolución</label>
                                <input type="file" name="anexo_resolucion" class="form-control" accept="application/pdf">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a estudiantes del sistema de responsabilidad penal?</label>
                                <select name="atencion_responsabilidad_penal" class="form-control" required>
                                    <option value="no">No</option>
                                    <option value="si">Sí</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a estudiantes del sistema nacional de protección?</label>
                                <select name="atencion_sistema_nacional" class="form-control" required>
                                    <option value="no">No</option>
                                    <option value="si">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a población étnica?</label>
                                <select name="atencion_poblacion_etnica" class="form-control" required>
                                    <option value="no">No</option>
                                    <option value="si">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="{{ route('educational-offer.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tiene_autorizacion').addEventListener('change', function () {
            const anexoContainer = document.getElementById('anexo_resolucion_container');
            anexoContainer.style.display = this.value === 'si' ? 'block' : 'none';
        });
    </script>
@endsection
