@extends('layouts.login')

@section('content')
    <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center">
            <a href="{{ url('login')}}" class="app-brand-link gap-2">
            <img src="{{ asset('imagenes/educacion_menu-nobg.png')}}" alt="Secretaria de Educación" width="100%">
            </a>
        </div>
        <h4 class="mb-2">¿Olvidaste tu contraseña? 🔒</h4>
        <p class="mb-4">Ingresa tu correo electrónico y te enviaremos instrucciones para restablecerla.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Ingresa tu correo" value="{{ old('email') }}" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button class="btn btn-warning d-grid w-100">Enviar enlace de recuperación</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                Volver al inicio de sesión
            </a>
        </div>
    </div>
@endsection
