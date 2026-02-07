@extends('layouts.login')

@section('content')
    <div class="card-body px-4 py-5">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('imagenes/educacion_menu-nobg.png')}}" alt="Secretaria de Educación" style="max-width: 280px; width: 100%;">
        </div>

        <style>
            #email::placeholder,
            #password::placeholder {
                color: #000000;
                opacity: 1;
            }
        </style>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Input -->
            <div class="mb-3">
                <input id="email"
                       type="email"
                       class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-lg @error('email') is-invalid @enderror @error('access_denied') is-invalid @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="CORREO ELECTRÓNICO"
                       required
                       autocomplete="email"
                       autofocus
                       style="border-radius: 15px; padding: 12px 20px; border: 2px solid #95d0e8 !important;">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('access_denied')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <input id="password"
                       type="password"
                       class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill !border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill-lg @error('password') is-invalid @enderror"
                       name="password"
                       placeholder="CONTRASEÑA"
                       required
                       autocomplete="current-password"
                       style="border-radius: 15px; padding: 12px 20px; border: 2px solid #95d0e8 !important;">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100" style="border-radius: 25px; padding: 12px 20px; font-weight: 500; background-color: #4a90e2; border: none; text-transform: uppercase;">
                    Iniciar sesión
                </button>
            </div>

            <!-- Forgot Password Link -->
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: #000; text-decoration: none; font-size: 14px;">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection
