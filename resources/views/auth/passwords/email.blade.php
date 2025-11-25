@extends('layouts.login')

@section('content')
    <div class="card-body">
        <div class="app-brand justify-content-center mb-4">
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                <img src="{{ asset('imagenes/educacion_menu-nobg.png') }}" alt="Secretaria de Educación" width="100%">
            </a>
        </div>
        
        <h4 class="mb-3">{{ __('Restablecer Contraseña') }}</h4>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('Enviar enlace de restablecimiento') }}
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
