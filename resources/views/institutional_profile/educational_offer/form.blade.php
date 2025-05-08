@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
    ></div>
    <div class="container">
        <div class="card">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="card-header">
                <h1>Crear Oferta Educativa</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('educational-offer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Modelos educativos -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modelos" class="form-label">Modelos Educativos</label>
                                <select name="educational_models[]" class="form-control" multiple required>
                                    @foreach($eduactionalModels as $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tiene_autorizacion" class="form-label">¿Tiene autorización para validación de estudios?</label>
                                <select name="educational_offer[has_study_validation_auth]" class="form-control" id="tiene_autorizacion" required>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="anexo_resolucion_container" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="anexo_resolucion" class="form-label">Anexo Resolución</label>
                                <input type="file" name="validation_authorization" class="form-control" accept="application/pdf">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a estudiantes del sistema de responsabilidad penal?</label>
                                <select name="educational_offer[serves_juvenile_justice]" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a estudiantes del sistema nacional de protección?</label>
                                <select name="educational_offer[serves_national_protection_students]" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a población étnica?</label>
                                <select name="educational_offer[serves_ethnic_population]" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre de la oferta educativa</label>
                                <input type="text" name="educational_offer[name]" class="form-control" required>
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
            anexoContainer.style.display = this.value === '1' ? 'block' : 'none';
        });
    </script>
@endsection
