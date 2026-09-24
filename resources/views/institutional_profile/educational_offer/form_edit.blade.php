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
                <h1>Actualizar oferta educativa</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('educational-offer.update',[ 'educational_offer' => $educationalOffer->id ]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Modelos educativos -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modelos" class="block text-sm mb-2 ml-4">Modelos educativos</label>
                                <select name="educational_models[]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" multiple required>
                                    @foreach($eduactionalModels as $model)
                                        <option value="{{ $model->id }}" @selected($educationalOffer->educationalModels->contains('id', $model->id))>
                                            {{ $model->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tiene_autorizacion" class="block text-sm mb-2 ml-4">¿Tiene autorización para validación de estudios?</label>
                                <select name="educational_offer[has_study_validation_auth]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" id="tiene_autorizacion" required>
                                    <option value="0" {{ $educationalOffer->has_study_validation_auth == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->has_study_validation_auth == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="anexo_resolucion_container" style="display: {{ $educationalOffer->validationAuthorizationAdjunto != null ? 'block' : 'none' }};">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="anexo_resolucion" class="block text-sm mb-2 ml-4">Anexo Resolución</label>
                                    @if($educationalOffer->validationAuthorizationAdjunto?->url)
                                        <a href="{{ $educationalOffer->validationAuthorizationAdjunto?->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver anexo
                                        </a>
                                    @endif
                                <input type="file" name="validation_authorization" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" accept="application/pdf">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="block text-sm mb-2 ml-4">¿Atención a estudiantes del sistema de responsabilidad penal?</label>
                                <select name="educational_offer[serves_juvenile_justice]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" required>
                                    <option value="0" {{ $educationalOffer->serves_juvenile_justice == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->serves_juvenile_justice == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="block text-sm mb-2 ml-4">¿Atención a estudiantes del sistema nacional de protección?</label>
                                <select name="educational_offer[national_protection_students]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" required>
                                    <option value="0" {{ $educationalOffer->serves_national_protection_students == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->serves_national_protection_students == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="block text-sm mb-2 ml-4">¿Atención a población étnica?</label>
                                <select name="educational_offer[serves_ethnic_population]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" required>
                                    <option value="0" {{ $educationalOffer->serves_ethnic_population == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->serves_ethnic_population == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="block text-sm mb-2 ml-4">Nombre de la oferta educativa</label>
                                <input type="text" name="educational_offer[name]" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" value="{{ $educationalOffer->name }}" required>
                            </div>
                        </div>


                    </div>
                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="{{ route('educational-offer.index') }}" class="border bg-blue-500  text-white p-2 rounded-pill">
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
