@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h1 class="card-header">Sedes</h1>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('sede.create') }}" class="btn btn-primary mb-3">Crear Sede</a>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DANE</th>
                            <th>DIRECCIÓN</th>
                            <th>ZONA</th>
                            <th>TIPO DE SEDE</th>
                            <th>ACCIONES</th>


                        </tr>
                        </thead>
                        <tbody>
                            <!-- Institución 1 -->
                            <tr>
                                <td>Colegio San José</td>
                                <td>123456789001</td>
                                <td>Calle 10 # 5-20</td>
                                <td>Norte</td>
                                <td>PRINCIPAL</td>
                                <td>
                                    <a href="{{ route('sede.edit', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('sede.destroy', 1) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta sede?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Institución 2 -->
                            <tr>
                                <td>Instituto Técnico Central</td>
                                <td>123456789002</td>
                                <td>Carrera 15 # 20-30</td>
                                <td>Centro</td>
                                <td>ADSCRITA</td>
                                <td>
                                    <a href="{{ route('sede.edit', 2) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('sede.destroy', 2) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta sede?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Institución 3 -->
                            <tr>
                                <td>Liceo Moderno de Bogotá</td>
                                <td>123456789003</td>
                                <td>Avenida 30 # 45-60</td>
                                <td>Sur</td>
                                <td>PRINCIPAL</td>
                                <td>
                                    <a href="{{ route('sede.edit', 3) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="{{ route('sede.destroy', 3) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta sede?')">Eliminar</button>
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
