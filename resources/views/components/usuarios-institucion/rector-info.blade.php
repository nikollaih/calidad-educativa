@props(['rector'])

@if($rector)
    <div class="mt-4 rounded-xl border border-custom-blue-light bg-custom-gray-light p-4">
        <div class="mb-2 flex items-center gap-2">
            <i class="fa fa-user-tie text-custom-blue-light" aria-hidden="true"></i>
            <h2 class="mb-0 text-lg font-semibold text-custom-primary">Rector de la institución</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <span class="text-muted d-block">Nombre</span>
                <strong>{{ $rector->name }}</strong>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block">Correo electrónico</span>
                <strong>{{ $rector->email }}</strong>
            </div>
            <div class="col-md-4">
                <span class="text-muted d-block">Rol</span>
                <strong>Rector</strong>
            </div>
        </div>
    </div>
@endif
