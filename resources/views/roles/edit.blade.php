@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
        <h1 class="card-header">Edición del rol</h1>
        <div class="card-body">
            <div class="col-md-12">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Rol</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Permisos</label>
                        <div class="row">
                            @php
                                // Agrupar permisos por categoría
                                $groupedPermissions = [];
                                foreach($permissions as $permission) {
                                    // Extraer la categoría del nombre del permiso (parte después del prefijo)
                                    $parts = explode('-', $permission->name);
                                    if (count($parts) >= 2) {
                                        $category = $parts[1];
                                        if (!isset($groupedPermissions[$category])) {
                                            $groupedPermissions[$category] = [];
                                        }
                                        $groupedPermissions[$category][] = $permission;
                                    }
                                }
                                
                                // Ordenar categorías
                                ksort($groupedPermissions);
                                
                                // Dividir en columnas
                                $categories = array_keys($groupedPermissions);
                                $totalCategories = count($categories);
                                $categoriesPerColumn = ceil($totalCategories / 3);
                            @endphp
                            
                            @foreach(array_chunk($categories, $categoriesPerColumn, true) as $columnCategories)
                                <div class="col-md-4 col-lg-4">
                                    @foreach($columnCategories as $category)
                                        <div class="mb-3">
                                            <h6 class="fw-bold text-capitalize">{{ ucfirst(str_replace('_', ' ', $category)) }}</h6>
                                            @foreach($groupedPermissions[$category] as $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                                        {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name_translated }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

