@extends('layouts.guest')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100"
        style="background-image: url('https://via.placeholder.com/1920x1080?text=Background'); background-size: cover; background-position: center;">
        <div class="card shadow-lg w-25 mx-auto"
            style="background-color: rgba(255, 255, 255, 0.9); border-radius: 15px;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ $imgLogo }}" alt="Logo" class="img-fluid mb-3" style="max-width: 120px;">
                    <h5 class="card-title">{{ __('Restablecer Contraseña') }}</h5>
                    <p class="card-text">{{ __('Ingresa tu nueva contraseña.') }}</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email', $request->email) }}" required autofocus
                            autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                        <input id="password_confirmation" type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">{{ __('Restablecer Contraseña') }}</button>
                </form>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none"><i
                            class="fas fa-arrow-left me-1"></i>{{ __('Volver al inicio de sesión') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
