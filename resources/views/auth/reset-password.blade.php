@extends('layouts.login')

@section('content')
    <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center">
            <a href="{{ url('login')}}" class="app-brand-link gap-2">
            <img src="{{ asset('imagenes/educacion_menu-nobg.png')}}" alt="Secretaria de Educación" width="100%">
            </a>
        </div>
        <h4 class="mb-2">Restablecer Contraseña 🔒</h4>
        <p class="mb-4">Ingresa tu nueva contraseña.</p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label for="email" class="block text-sm mb-2 ml-4">Correo Electrónico</label>
                <input type="email" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 form-password-toggle">
                <label class="block text-sm mb-2 ml-4" for="password">Nueva Contraseña</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 form-password-toggle">
                <label class="block text-sm mb-2 ml-4" for="password_confirmation">Confirmar Contraseña</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="password_confirmation" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
            </div>

            <button class="btn btn-warning d-grid w-100 mb-3">
                Restablecer Contraseña
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}">
                    <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                    Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>
@endsection
