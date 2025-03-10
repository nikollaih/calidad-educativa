@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h1 class="card-header">Ofertas educativas</h1>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('educational-offer.create') }}" class="btn btn-primary mb-3">Crear Oferta educativa</a>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>JORNADAS</th>
                            <th>NIVELES</th>
                            <th>¿TIENE AUTORIZACIÓN PARA VALIDACIÓN DE ESTUDIOS?</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Oferta educativa 1 -->
                        <tr>
                            <td>Colegio San José</td>
                            <td>
                                <ul>
                                    <li>Mañana</li>
                                    <li>Tarde</li>
                                    <li>Nocturna</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Preescolar: Prejardín, Jardín, Transición</li>
                                    <li>Básica: Primaria (1°-5°), Secundaria (6°-9°)</li>
                                    <li>Media: Académica (10°-11°) - Énfasis en Bilingüismo</li>
                                </ul>
                            </td>
                            <td>Sí</td>
                            <td>
                                <a href="{{ route('educational-offer.edit', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('educational-offer.destroy', 1) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta oferta educativa?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Oferta educativa 2 -->
                        <tr>
                            <td>Instituto Técnico Central</td>
                            <td>
                                <ul>
                                    <li>Única</li>
                                    <li>Dominical y Festivos</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Preescolar: Prejardín, Jardín, Transición</li>
                                    <li>Básica: Primaria (1°-5°), Secundaria (6°-9°)</li>
                                    <li>Media: Articulada (10°-11°) - SENA</li>
                                </ul>
                            </td>
                            <td>No</td>
                            <td>
                                <a href="{{ route('educational-offer.edit', 2) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('educational-offer.destroy', 2) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta oferta educativa?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Oferta educativa 3 -->
                        <tr>
                            <td>Liceo Moderno de Bogotá</td>
                            <td>
                                <ul>
                                    <li>Mañana</li>
                                    <li>Tarde</li>
                                    <li>Nocturna</li>
                                    <li>Dominical y Festivos</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Preescolar: Prejardín, Jardín, Transición</li>
                                    <li>Básica: Primaria (1°-5°), Secundaria (6°-9°)</li>
                                    <li>Media: Académica (10°-11°) - Énfasis en Educación Artística</li>
                                </ul>
                            </td>
                            <td>Sí</td>
                            <td>
                                <a href="{{ route('educational-offer.edit', 3) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('educational-offer.destroy', 3) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta oferta educativa?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
