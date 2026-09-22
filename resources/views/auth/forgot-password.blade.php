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
                <label for="email" class="block text-sm mb-2 ml-4">Correo Electrónico</label>
                <input type="text" class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill @error('email') is-invalid @enderror" id="email" name="email" placeholder="Ingresa tu correo" value="{{ old('email') }}" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button class="border bg-blue-500  text-white p-2 rounded-pill d-grid w-100">Enviar enlace de recuperación</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                Volver al inicio de sesión
            </a>
        </div>
    </div>
@endsection
