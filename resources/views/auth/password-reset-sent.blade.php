@extends('layouts.login')

@section('content')
    <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center">
            <a href="{{ url('login')}}" class="app-brand-link gap-2">
            <img src="{{ asset('imagenes/educacion_menu-nobg.png')}}" alt="Secretaría de Educación" width="100%">
            </a>
        </div>
        <h4 class="mb-2">¡Correo enviado! 📧</h4>
        <p class="mb-4">Hemos enviado un enlace de recuperación a tu correo, por medio del cual podrás restablecer tu contraseña.</p>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                Volver al inicio de sesión
            </a>
        </div>
    </div>
@endsection
