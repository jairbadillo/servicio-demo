
@extends('layouts.guest')

@section('content')
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="left-section col-12 col-sm-12 col-lg-6">
                <h1>Bienvenido a nuestro sistema.........</h1>
            </div>
            <div class="right-section col-12 col-sm-12 col-lg-6">
                <div class="login-container">
                    <img src="{{ asset('images/logo-demo.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                    <hr>
                    <h2>Bienvenidos!</h2>
                    <p>Inicia sesión con tu cuenta y comienza la aventura.</p>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="input-group mb-3">
                            <input type="password" class="form-control mb-0 @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="Password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash-fill"></i>
                            </button>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="remember-me mb-3">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuérdame
                            </label>
                        </div>

                        <button type="submit" class="btn btn-login">LOGIN</button>

                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                        </div>

                        {{-- <div class="create-account">
                            Eres nuevo? <a href="{{ route('register') }}">Cree una cuenta</a>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
