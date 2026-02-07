<section class="">
    <div class="card border-0 shadow-sm">
        <div class="card-header py-2 bg-primary text-white">
            <h2 class="h6 mb-0 text-white">Información de Perfil</h2>
        </div>

        <div class="card-body p-3">
            <p class="text-muted small mb-3">
                Actualiza la información de tu cuenta y tu correo electrónico.
            </p>

            {{-- Formulario para reenviar verificación --}}
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            {{-- Formulario de actualización --}}
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-2">
                    <label for="name" class="block text-sm mb-2 ml-4 small mb-1">Nombre</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-sm @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="email" class="block text-sm mb-2 ml-4 small mb-1">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-sm @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="alert alert-warning py-1 px-2 mt-2 small mb-1">
                            Tu correo electrónico no está verificado.
                            <button
                                type="submit"
                                form="send-verification"
                                class="btn btn-link btn-sm p-0 align-baseline"
                            >
                                Reenviar verificación
                            </button>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success py-1 px-2 small mt-1 mb-1">
                                Se envió un nuevo enlace de verificación.
                            </div>
                        @endif
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2 mt-3">
                    <button type="submit" class="btn btn-success btn-sm">
                        Guardar
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-success small fw-semibold"
                        >
                            Cambios guardados
                        </span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>

