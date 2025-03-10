@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Editar Sede</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('sede.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <!-- Campos existentes -->
                            <div class="mb-3">
                                <label for="tipo_sede" class="form-label">Tipo de Sede</label>
                                <select name="tipo_sede" id="tipo_sede" class="form-control" required>
                                    <option value="Principal">Principal</option>
                                    <option value="Adscrita a una principal">Adscrita a una principal</option>
                                </select>
                            </div>
                            <div class="mb-3" id="sede_principal_container" style="display: none;">
                                <label for="sede_principal_id" class="form-label">Sede Principal</label>
                                <select name="sede_principal_id" id="sede_principal_id" class="form-control">
                                    <option value="">Seleccione una sede principal</option>
                                    @php
                                        $sedes_principales = [
                                            (object) ['id' => 1, 'nombre' => 'Sede Principal Norte'],
                                            (object) ['id' => 2, 'nombre' => 'Sede Principal Sur'],
                                            (object) ['id' => 3, 'nombre' => 'Sede Principal Centro'],
                                        ];
                                    @endphp
                                    @foreach ($sedes_principales as $sede)
                                        <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="dane" class="form-label">Código DANE</label>
                                <input type="text" name="dane" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="titularidad_sede" class="form-label">Titularidad de la Sede</label>
                                <select name="titularidad_sede" id="titularidad_sede" class="form-control w-full" required>
                                    <option value="Municipio">Municipio</option>
                                    <option value="Departamento">Departamento</option>
                                    <option value="Comité de Cafeteros">Comité de Cafeteros</option>
                                    <option value="Otro">Otro</option>
                                    <option value="En arriendo">En arriendo</option>
                                </select>
                            </div>
                            <div class="row" id="otro_titularidad_container" style="display: none;">
                                <div class="mb-3">
                                    <label for="otro_titularidad" class="form-label">Especifique</label>
                                    <input type="text" name="otro_titularidad" class="form-control">
                                </div>
                            </div>

                            <div class="row" id="anexo_certificado_container" style="display: none;">
                                <div class="mb-3">
                                    <label for="anexo_certificado" class="form-label">Anexar Certificado de Libertad y Tradición u otro</label>
                                    <input type="file" name="anexo_certificado" class="form-control" accept="application/pdf">
                                </div>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <!-- Campos existentes -->
                            <div class="mb-3">
                                <label for="zona" class="form-label">Zona</label>
                                <input type="text" name="zona" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="longitud" class="form-label">Longitud</label>
                                <input type="text" name="longitud" class="form-control" placeholder="Ej: -74.123456" required>
                            </div>

                            <div class="mb-3">
                                <label for="latitud" class="form-label">Latitud</label>
                                <input type="text" name="latitud" class="form-control" placeholder="Ej: 4.123456" required>
                            </div>

                            <div class="mb-3">
                                <label for="acto_administrativo" class="form-label">Acto Administrativo (Opcional)</label>
                                <input type="file" name="acto_administrativo" class="form-control" accept="application/pdf">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">¿Es escuela nueva?</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="escuela_nueva" id="escuela_nueva_si" value="1" required>
                                        <label class="form-check-label" for="escuela_nueva_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="escuela_nueva" id="escuela_nueva_no" value="0" required>
                                        <label class="form-check-label" for="escuela_nueva_no">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Nuevo campo: ¿Cuenta con aulas STEAM? -->
                            <div class="mb-3">
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="cuenta_aulas_steam" id="cuenta_aulas_steam" value="1">
                                        <label class="form-check-label" for="cuenta_aulas_steam">¿Cuenta con aulas STEAM?</label>
                                    </div>
                                </div>
                            </div>



                            <!-- Sección de equipos (oculta inicialmente) -->
                            <div id="aulas_steam_container" style="display: none;">
                                <label class="form-label">Equipos disponibles</label>
                                @php
                                    $equipos = [
                                        'Equipo Servidor',
                                        'Computadores de escritorio para uso académico en buen estado',
                                        'Computadores portátiles para uso académico en buen estado',
                                        'Tabletas para uso académico en buen estado',
                                        'Pantallas interactivas en buen estado',
                                        'Computadores de escritorio para uso administrativo en buen estado',
                                        'Computadores portátiles para uso administrativo en buen estado',
                                        'Routers',
                                        'Switch de red',
                                        'Access Point',
                                        'Proyectores / Videobeam',
                                        'Kit de robótica',
                                        'Kit STEM',
                                        'Arduinos',
                                        'Microbit',
                                        'UPS',
                                        'Brazo robótico',
                                        'Impresora 3D',
                                        'Televisores',
                                        'Cabinas de sonido',
                                    ];
                                @endphp
                                @foreach ($equipos as $equipo)
                                    <div class="mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="equipos[]" id="equipo_{{ Str::slug($equipo) }}" value="{{ $equipo }}">
                                                    <label class="form-check-label" for="equipo_{{ Str::slug($equipo) }}">{{ $equipo }}</label>
                                                </div>
                                            </div>
                                            <!-- Campos adyacentes para financiación y cantidad -->
                                            <div class="col-md-5">
                                                <div id="label_fuente_{{ Str::slug($equipo) }}" style="display: none;">
                                                    <label class="form-check-label">Fuente de financiación</label>
                                                </div>
                                                <select name="fuente_financiacion_{{ Str::slug($equipo) }}" id="fuente_financiacion_{{ Str::slug($equipo) }}" class="form-control" style="display: none;">
                                                    <option value="Computadores para educar">Computadores para educar</option>
                                                    <option value="Regalías: Bilingüismo, Innovación Social">Regalías: Bilingüismo, Innovación Social</option>
                                                    <option value="Aula Steam">Aula Steam</option>
                                                    <option value="Obras por impuestos">Obras por impuestos</option>
                                                    <option value="Recursos propios">Recursos propios</option>
                                                    <option value="Donación entidad estatal">Donación entidad estatal</option>
                                                    <option value="Donación entidad privada">Donación entidad privada</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="label_cantidad_{{ Str::slug($equipo) }}" style="display: none;">
                                                    <label class="form-check-label">Cantidad</label>
                                                </div>
                                                <input type="number" name="cantidad_{{ Str::slug($equipo) }}" id="cantidad_{{ Str::slug($equipo) }}" class="form-control" style="display: none;" placeholder="Cantidad">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="{{ route('sede.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para manejar la lógica de los campos -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cuentaAulasSteam = document.getElementById('cuenta_aulas_steam');
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
            // Mostrar/ocultar campos de aulas STEAM y equipos
            cuentaAulasSteam.addEventListener('change', function () {
                if (this.checked) {
                    aulasSteamContainer.style.display = 'block';
                    equiposContainer.style.display = 'block';
                } else {
                    aulasSteamContainer.style.display = 'none';
                    equiposContainer.style.display = 'none';
                }
            });

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
    </script>
@endsection
