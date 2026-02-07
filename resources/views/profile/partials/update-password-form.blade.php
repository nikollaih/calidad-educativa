
<section class="">
    <div class="card border-0 shadow-sm">
        <div class="card-header py-2 bg-primary text-white">
            <h2 class="h6 mb-0 text-white">Actualizar Contraseña</h2>
        </div>

        <div class="card-body p-3">
            <p class="text-muted small mb-3">
                Asegúrate de usar una contraseña larga y aleatoria para mantener tu cuenta segura.
            </p>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-2">
                    <label for="update_password_current_password" class="block text-sm mb-2 ml-4 small mb-1">Contraseña actual</label>
                    <input
                        type="password"
                        id="update_password_current_password"
                        name="current_password"
                        class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-sm @error('current_password', 'updatePassword') is-invalid @enderror"
                        autocomplete="current-password"
                    >
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="update_password_password" class="block text-sm mb-2 ml-4 small mb-1">Nueva contraseña</label>
                    <input
                        type="password"
                        id="update_password_password"
                        name="password"
                        class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-sm @error('password', 'updatePassword') is-invalid @enderror"
                        autocomplete="new-password"
                    >
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="update_password_password_confirmation" class="block text-sm mb-2 ml-4 small mb-1">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-sm @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                        autocomplete="new-password"
                    >
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-2 mt-3">
                    <button type="submit" class="btn btn-success btn-sm">
                        Actualizar contraseña
                    </button>

                    @if (session('status') === 'password-updated')
                        <span
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-success small fw-semibold"
                        >
                            Contraseña actualizada
                        </span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>

