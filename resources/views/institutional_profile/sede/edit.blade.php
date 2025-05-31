@extends('layouts.app')

@section('content')
    <div
        data-component="CBackButton"
    ></div>
    <div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        <div class="card">
            <div class="card-header">
                <h1>Editar Sede </h1>
            </div>
            <div class="card-body">
                <form action="{{ route('sede.update', [ 'sede' => $sede->id ] ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="sede[institution_id]" class="form-control" value="{{ $sede->institution_id }}" required>
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <!-- Campos existentes -->
                            <div class="mb-3">
                                <label for="tipo_sede" class="form-label">Tipo de Sede</label>
                                <select name="tipo_sede" id="tipo_sede" class="form-control" required>
                                    <option value="Principal" @selected($sede->parentSede == null)>Principal</option>
                                    <option value="Adscrita a una principal" @selected($sede->parentSede != null)>Adscrita a una principal</option>
                                </select>
                            </div>
                            <div class="mb-3" id="sede_principal_container" style="display: none;">
                                <label for="sede_principal_id" class="form-label">Sede Principal</label>
                                <select name="sede[parent_sede_id]" id="sede_principal_id" class="form-control">
                                    <option value="">Seleccione una sede principal</option>
                                    @foreach ($availableSedes as $sede_principal)
                                        <option value="{{ $sede_principal->id }}" @selected($sede?->parentSede?->id == $sede_principal->id )>{{ $sede_principal->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sede[name]" class="form-label">Nombre</label>
                                <input type="text" name="sede[name]" class="form-control" value="{{ $sede->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="sede[dane]" class="form-label">Código DANE</label>
                                <input type="text" name="sede[dane]" class="form-control" value="{{ $sede->dane }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="sede[address]" class="form-label">Dirección</label>
                                <input type="text" name="sede[address]" class="form-control" value="{{ $sede->address }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="titularidad_sede" class="form-label">Titularidad de la Sede</label>
                                    @if($sede?->titularidadSede?->adjunto?->url)
                                        <a href="{{ $sede?->titularidadSede?->adjunto?->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver anexo
                                        </a>
                                    @endif
                                <select name="titularity[titularity_type]" id="titularidad_sede" class="form-control w-full"  required>
                                    <option value="Municipio" @selected($sede?->titularidadSede?->titularity_type == 'Municipio')>Municipio</option>
                                     <option value="Departamento" @selected($sede?->titularidadSede?->titularity_type == 'Departamento')>Departamento</option>
                                     <option value="Comité de Cafeteros" @selected($sede?->titularidadSede?->titularity_type == 'Comité de Cafeteros')>Comité de Cafeteros</option>
                                     <option value="Otro" @selected($sede?->titularidadSede?->titularity_type == 'Otro')>Otro</option>
                                     <option value="En arriendo" @selected($sede?->titularidadSede?->titularity_type == 'En arriendo')>En arriendo</option>
                                </select>
                            </div>
                            <div class="row" id="otro_titularidad_container" style="display: none;">
                                <div class="mb-3">
                                    <label for="otro_titularidad" class="form-label">Especifique</label>
                                    <input type="text" name="titularity[name]" class="form-control">
                                </div>
                            </div>

                            <div class="row" id="anexo_certificado_container" >
                                <div class="mb-3">
                                    <label for="anexo_certificado" class="form-label">Anexar Certificado de Libertad y Tradición u otro</label>
                                    <input type="file" name="titularity_certificate" class="form-control" accept="application/pdf" >
                                </div>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <!-- Campos existentes -->
                            <div class="mb-3">
                                <label for="sede[zone]" class="form-label">Zona</label>
                                <select name="sede[zone]" id="titularidad_sede" class="form-control w-full"  required>
                                   <option value="RURAL" {{ $sede->zone == 'RURAL' ? 'selected' : '' }}>Rural</option>
                                   <option value="URBANA" {{ $sede->zone == 'URBANA' ? 'selected' : '' }}>Urbana</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sede[longitude]" class="form-label">Longitud</label>
                                <input type="text" name="sede[longitude]" class="form-control" placeholder="Ej: -74.123456" value="{{ $sede->longitude  }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="sede[latitude]" class="form-label">Latitud</label>
                                <input type="text" name="sede[latitude]" class="form-control" placeholder="Ej: 4.123456" value="{{ $sede->latitude  }}" required>
                            </div>

                            <div class="mb-3">
                                    <label for="administrative_act_file" class="form-label">Acto Administrativo (Opcional)</label>
                                    @if($sede?->administrativeAct?->url)
                                        <a href="{{ $sede?->administrativeAct?->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver anexo
                                        </a>
                                    @endif
                                <input type="file" name="administrative_act_file" class="form-control" accept="application/pdf">
                            </div>

                            <div class="mb-3">
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sede[is_new_school]" id="sede[is_new_school]" value="{{ $sede->is_new_school }}" @if($sede->is_new_school == 1) checked @endif >
                                        <label class="form-check-label" for="sede[is_new_school]">¿Tiene Implementado modelo Escuela Nueva?</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div>
                            <!-- Sección de Aulas Steam -->
                            <div id="aulas_steam_container" class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aulas_steam_checkbox" @if($sede->steamClassroom != null) checked @endif>
                                    <label class="form-check-label" for="aulas_steam_checkbox">¿Cuenta con Aulas Steam?</label>
                                </div>
                            </div>

                            <!-- Campos adicionales ocultos -->
                            <div id="aulas_steam_fields" style="display: {{ $sede->steamClassroom != null ? 'block' : 'none' }};" >
                                <div class="row">
                                    <!-- Campo para cantidad de aulas -->
                                    <div class="col-md-6">
                                        <label class="form-label" for="cantidad_aulas">¿Cuántas?</label>
                                        <input type="number" id="cantidad_aulas" name="steam_classroom[quantity]" class="form-control" min="1" value="{{$sede?->steamClassroom?->quantity}}" placeholder="Ingrese cantidad">
                                    </div>

                                    <!-- Campo para fase -->
                                    <div class="col-md-6">
                                        <label class="form-label" for="fase_aula">Fase</label>
                                        <select name="steam_classroom[phase]"  class="form-control w-full" required>

                                            <option value="Fase 1" {{ $sede->steamClassroom?->phase == 'Fase 1' ? 'selected' : '' }}>Fase 1</option>
                                            <option value="Fase 2" {{ $sede->steamClassroom?->phase == 'Fase 2' ? 'selected' : '' }}>Fase 2</option>
                                            <option value="Fase 3" {{ $sede->steamClassroom?->phase == 'Fase 3' ? 'selected' : '' }}>Fase 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="form-label">Equipos disponibles</label>

                            <!-- Sección de equipos (oculta inicialmente) -->
                            <div class="row  row-cols-md-1" >
                                @php
                                    $equipos = [
                                        'Equipo Servidor.',
                                        'Computadores de escritorio para uso académico en buen estado.',
                                        'Computadores portátiles para uso académico en buen estado.',
                                        'Tabletas para uso académico en buen estado.',
                                        'Pantallas interactivas en buen estado.',
                                        'Computadores de escritorio para uso administrativo en buen estado.',
                                        'Computadores portátiles para uso administrativo en buen estado.',
                                        'Routers.',
                                        'Switch de red.',
                                        'Access Point.',
                                        'Proyectores / Videobeam.',
                                        'Kit de robótica.',
                                        'Kit STEM.',
                                        'Arduinos.',
                                        'Microbit.',
                                        'UPS.',
                                        'Brazo robótico.',
                                        'Impresora 3D.',
                                        'Televisores.',
                                        'Cabinas de sonido.',
                                    ];
                                @endphp
                                @foreach ($equipos as $key => $equipo)
                                    <div class="mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="equipos[]" id="equipo_{{ Str::slug($equipo) }}" value="{{ $equipo }}" @if($sede->inventories->firstWhere('name', Str::slug($equipo))) checked @endif >
                                                    <label class="form-check-label" for="equipo_{{ Str::slug($equipo) }}">{{ $equipo }}</label>
                                                </div>
                                            </div>
                                            <!-- Campos adyacentes para financiación y cantidad -->
                                            <div class="col-md-5">
                                                <div id="label_fuente_{{ Str::slug($equipo) }}" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};" >
                                                    <label class="form-check-label">Fuente de financiación.</label>
                                                </div>
                                                <input hidden name="inventory[{{$key}}][name]" value="{{Str::slug($equipo)}}">
                                                <select name="inventory[{{$key}}][financing_source]" id="fuente_financiacion_{{ Str::slug($equipo) }}" class="form-control" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};">
                                                    <option value="Computadores para educar"  {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Computadores para educar')->count() > 0 ? 'selected' : '' }}>Computadores para educar</option>
                                                    <option value="Regalías: Bilingüismo, Innovación Social" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Regalías: Bilingüismo, Innovación Social')->count() > 0 ? 'selected' : '' }}>Regalías: Bilingüismo, Innovación Social</option>
                                                    <option value="Aula Steam" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Aula Steam')->count() > 0 ? 'selected' : '' }}>Aula Steam</option>
                                                    <option value="Obras por impuestos" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Obras por impuestos')->count() > 0 ? 'selected' : '' }}>Obras por impuestos</option>
                                                    <option value="Recursos propios" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Recursos propios')->count() > 0 ? 'selected' : '' }}>Recursos propios</option>
                                                    <option value="Donación entidad estatal" {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Donación entidad estatal')->count() > 0 ? 'selected' : '' }}>Donación entidad estatal</option>
                                                    <option value="Donación entidad privada"  {{ $sede->inventories->where('name', Str::slug($equipo))->where('financing_source', 'Donación entidad privada')->count() > 0 ? 'selected' : '' }}>Donación entidad privada</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="label_cantidad_{{ Str::slug($equipo) }}" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};">
                                                    <label class="form-check-label">Cantidad.</label>
                                                </div>
                                                <input type="number" name="inventory[{{$key}}][quantity]" id="cantidad_{{ Str::slug($equipo) }}" class="form-control" style="display: {{ $sede->inventories->firstWhere('name', Str::slug($equipo)) != null ? 'block' : 'none' }};" placeholder="Cantidad" value="{{  $sede->inventories->firstWhere('name', Str::slug($equipo))?->quantity}}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="m-3">
                    <div class="row">
                        <!-- Modelos educativos -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modelos" class="form-label">Modelos Educativos Flexibles.</label>
                                <select name="educational_models[]" class="form-control" multiple>
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
                                <label for="tiene_autorizacion" class="form-label">¿Tiene autorización para validación de estudios?</label>
                                <select name="educational_offer[has_study_validation_auth]" class="form-control" id="tiene_autorizacion" required>
                                    <option value="0" {{ $educationalOffer->has_study_validation_auth == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->has_study_validation_auth == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="anexo_resolucion_container" style="display: {{ $educationalOffer->validationAuthorizationAdjunto != null ? 'block' : 'none' }};">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="anexo_resolucion" class="form-label">Anexo Resolución</label>
                                    @if($educationalOffer->validationAuthorizationAdjunto?->url)
                                        <a href="{{ $educationalOffer->validationAuthorizationAdjunto?->url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver anexo
                                        </a>
                                    @endif
                                <input type="file" name="validation_authorization" class="form-control" accept="application/pdf">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a estudiantes del sistema de responsabilidad penal?</label>
                                <select name="educational_offer[serves_juvenile_justice]" class="form-control" required>
                                    <option value="0" {{ $educationalOffer->serves_juvenile_justice == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->serves_juvenile_justice == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a estudiantes del sistema nacional de protección?</label>
                                <select name="educational_offer[national_protection_students]" class="form-control" required>
                                    <option value="0" {{ $educationalOffer->national_protection_students == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->national_protection_students == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Atención a población étnica?</label>
                                <select name="educational_offer[serves_ethnic_population]" class="form-control" required>
                                    <option value="0" {{ $educationalOffer->serves_ethnic_population == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $educationalOffer->serves_ethnic_population == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="{{ route('institution.edit', [ 'institution' => $sede->institution_id ]) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para manejar la lógica de los campos -->
    <script>
        document.getElementById('tiene_autorizacion').addEventListener('change', function () {
            const anexoContainer = document.getElementById('anexo_resolucion_container');
            anexoContainer.style.display = this.value === '1' ? 'block' : 'none';
        });
        document.addEventListener('DOMContentLoaded', function () {
            const aulasSteamContainer = document.getElementById('aulas_steam_container');
            const equiposContainer = document.getElementById('equipos_container');
            const tipoSedeSelect = document.getElementById('tipo_sede');
            const sedePrincipalContainer = document.getElementById('sede_principal_container');

            tipoSedeSelect.addEventListener('change', function () {
                if (this.value === 'Adscrita a una principal') {
                    sedePrincipalContainer.style.display = 'block';
                } else {
                    sedePrincipalContainer.style.display = 'none';
                }
            });

            // Ejecutar al cargar la página para manejar el estado inicial
            if (tipoSedeSelect.value === 'Adscrita a una principal') {
                sedePrincipalContainer.style.display = 'block';
            }
            const equiposCheckboxes = document.querySelectorAll('input[name="equipos[]"]');
            equiposCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const equipoId = this.id.replace('equipo_', '');
                    const labelFuente = document.getElementById(`label_fuente_${equipoId}`);
                    const labelCantidad = document.getElementById(`label_cantidad_${equipoId}`);
                    const fuenteFinanciacion = document.getElementById(`fuente_financiacion_${equipoId}`);
                    const cantidad = document.getElementById(`cantidad_${equipoId}`);

                    if (this.checked) {
                        labelFuente.style.display = 'block';
                        labelCantidad.style.display = 'block';
                        fuenteFinanciacion.style.display = 'block';
                        cantidad.style.display = 'block';
                    } else {
                        labelFuente.style.display = 'none';
                        labelCantidad.style.display = 'none';
                        fuenteFinanciacion.style.display = 'none';
                        cantidad.value='';
                        cantidad.style.display = 'none';
                    }
                });
            });

        });
        document.getElementById('titularidad_sede').addEventListener('change', function () {
            const otroContainer = document.getElementById('otro_titularidad_container');
            const anexoContainer = document.getElementById('anexo_certificado_container');

            if (this.value === 'Otro') {
                otroContainer.style.display = 'block';
            } else {
                otroContainer.style.display = 'none';
            }

            if (this.value !== 'En arriendo') {
                anexoContainer.style.display = 'block';
            } else {
                anexoContainer.style.display = 'none';
            }
        });
            document.getElementById('aulas_steam_checkbox').addEventListener('change', function () {
                let fields = document.getElementById('aulas_steam_fields');
                if (this.checked) {
                    fields.style.display = 'block';
                } else {
                    fields.style.display = 'none';
                    const cantidadInput = document.getElementById('cantidad_aulas');
                    cantidadInput.value = '';

                }
            });

    </script>
@endsection
