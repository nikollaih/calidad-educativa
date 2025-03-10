@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <h1 class="card-header">Instituciones</h1>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('institution.create') }}" class="btn btn-primary mb-3">Crear institución</a>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>NIT</th>
                            <th>DANE</th>
                            <th>EMAIL</th>
                            <th>NOMBRE DEL RECTOR</th>
                            <th>ACCIONES</th>

                        </tr>
                        </thead>
                        <tbody>
                        <!-- Institución 1 -->
                        <tr>
                            <td>Colegio San José</td>
                            <td>800.123.456-1</td>
                            <td>17654321</td>
                            <td>sanjose@colegio.edu.co</td>
                            <td>María González</td>
                            <td>
                                <a href="{{ route('institution.edit', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('institution.destroy', 1) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta institución?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Institución 2 -->
                        <tr>
                            <td>Instituto Técnico Central</td>
                            <td>900.234.567-2</td>
                            <td>23456789</td>
                            <td>itcentral@instituto.edu.co</td>
                            <td>Carlos Martínez</td>
                            <td>
                                <a href="{{ route('institution.edit', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('institution.destroy', 1) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta institución?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Institución 3 -->
                        <tr>
                            <td>Liceo Moderno de Bogotá</td>
                            <td>700.345.678-3</td>
                            <td>34567890</td>
                            <td>liceomoderno@colegio.edu.co</td>
                            <td>Ana López</td>
                            <td>
                                <a href="{{ route('institution.edit', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('institution.destroy', 1) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta institución?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Institución 4 -->
                        <tr>
                            <td>Colegio La Salle</td>
                            <td>600.456.789-4</td>
                            <td>45678901</td>
                            <td>lasalle@colegio.edu.co</td>
                            <td>Jorge Ramírez</td>
                            <td>
                                <a href="{{ route('institution.edit', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('institution.destroy', 1) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta institución?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Institución 5 -->
                        <tr>
                            <td>Escuela Normal Superior</td>
                            <td>500.567.890-5</td>
                            <td>56789012</td>
                            <td>normal@escuela.edu.co</td>
                            <td>Laura Díaz</td>
                            <td>
                                <a href="{{ route('institution.edit', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('institution.destroy', 1) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta institución?')">Eliminar</button>
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
