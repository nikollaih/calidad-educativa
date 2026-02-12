@extends('layouts.login')

@section('content')
    <div class="card-body">
        <div class="app-brand justify-content-center mb-4">
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                <img src="{{ asset('imagenes/educacion_menu-nobg.png') }}" alt="Secretaria de Educación" width="100%">
            </a>
        </div>

        <h4 class="mb-3">{{ __('Restablecer Contraseña') }}</h4>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label for="email" class="block text-sm mb-2 ml-4">{{ __('Correo Electrónico') }}</label>
                <input id="email" type="email" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill @error('email') is-invalid @enderror"
                       name="email" value="{{ $request->email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="block text-sm mb-2 ml-4">{{ __('Nueva Contraseña') }}</label>
                <input id="password" type="password" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill @error('password') is-invalid @enderror"
                       name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="block text-sm mb-2 ml-4">{{ __('Confirmar Contraseña') }}</label>
                <input id="password-confirm" type="password" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
                       name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="border bg-blue-500  text-white p-2 rounded-pill">
                    {{ __('Restablecer Contraseña') }}
                </button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <a href="{{ route('login') }}" class="text-decoration-none">
                {{ __('Volver al inicio de sesión') }}
            </a>
        </div>
    </div>
@endsection
