@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Crear Institución</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('institution.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre_ie" class="form-label">Nombre de la Institución Educativa (IE)</label>
                                <input type="text" name="nombre_ie" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT</label>
                                <input type="text" name="nit" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="dane" class="form-label">Código DANE</label>
                                <input type="text" name="dane" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono_ie" class="form-label">Teléfono de la IE</label>
                                <input type="text" name="telefono_ie" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="pagina_web" class="form-label">Página Web</label>
                                <input type="url" name="pagina_web" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="licencia_funcionamiento" class="form-label">Licencia de Funcionamiento</label>
                                <input type="file" name="licencia_funcionamiento" class="form-control" accept="application/pdf" required>
                            </div>

                            <div class="mb-3">
                                <label for="nombre_rector" class="form-label">Nombre del Rector</label>
                                <input type="text" name="nombre_rector" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nombre_coordinador" class="form-label">Nombre del Coordinador/es</label>
                                <input type="text" name="nombre_coordinador" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="mb-3">
                        <label class="form-label">Redes Sociales</label>
                        <div id="redes-sociales-container" class="row">
                            @php
                                $redes = [
                                    ['icono' => 'fa-facebook', 'nombre' => 'Facebook'],
                                    ['icono' => 'fa-twitter', 'nombre' => 'Twitter'],
                                    ['icono' => 'fa-instagram', 'nombre' => 'Instagram'],
                                    ['icono' => 'fa-linkedin', 'nombre' => 'LinkedIn'],
                                ];
                            @endphp

                            @foreach ($redes as $index => $red)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <i class="fab {{ $red['icono'] }} fa-2x me-3"></i>
                                                <strong>{{ $red['nombre'] }}</strong>
                                            </div>
                                            <label class="form-label mt-2">URL</label>
                                            <input type="url" name="redes_sociales[{{ $index }}][url]" class="form-control"
                                                   placeholder="Ej: https://{{ strtolower($red['nombre']) }}.com">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fas fa-save "></i> Guardar
                        </button>
                        <a href="{{ route('institution.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
