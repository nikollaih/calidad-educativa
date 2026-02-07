
<section class="">
    <div class="card border-0 shadow-sm">
        <div class="card-header py-2 bg-danger text-white">
            <h2 class="h6 mb-0 text-white">Eliminar cuenta</h2>
        </div>

        <div class="card-body p-3">
            <p class="text-muted small mb-3">
                Una vez que elimines tu cuenta, todos tus recursos y datos serán eliminados de forma permanente.
                Descarga cualquier información que desees conservar antes de continuar.
            </p>

            <button
                type="button"
                class="btn btn-danger btn-sm"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >
                Eliminar cuenta
            </button>
        </div>
    </div>

    {{-- Modal de confirmación --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-3">
            @csrf
            @method('delete')

            <h2 class="h6 text-danger mb-2">¿Estás seguro de que deseas eliminar tu cuenta?</h2>

            <p class="text-muted small mb-3">
                Una vez eliminada, todos tus datos serán borrados de forma permanente.
                Ingresa tu contraseña para confirmar.
            </p>

            <div class="mb-2">
                <label for="password" class="block text-sm mb-2 ml-4 small mb-1">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-sm @error('password', 'userDeletion') is-invalid @enderror"
                    placeholder="Contraseña"
                >
                @error('password', 'userDeletion')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-secondary btn-sm" x-on:click="$dispatch('close')">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-danger btn-sm">
                    Eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>

