@extends('layouts.guest')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100"
        style="background-image: url('https://via.placeholder.com/1920x1080?text=Background'); background-size: cover; background-position: center;">
        <div class="card shadow-lg"
            style="max-width: 400px; background-color: rgba(255, 255, 255, 0.9); border-radius: 15px;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo-demo.png') }}" alt="logo" class="img-fluid mb-3" style="max-width: 120px;">
                    <h5 class="card-title">{{ __('¿Olvidaste tu contraseña?') }}</h5>
                    <p class="card-text">
                        {{ __('Ingresa tu correo electrónico y te enviaremos instrucciones para restablecer tu contraseña.') }}
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus />
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">{{ __('Enviar Enlace de Restablecimiento') }}</button>
                </form>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-1"></i>{{ __('Volver al inicio de sesión') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
