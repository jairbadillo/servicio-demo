@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Perfil</h2>
@endsection

@section('layoutContent')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Editar Perfil</h4>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <section class="container mt-5">
                            <header>
                                <h2 class="text-lg font-medium text-dark">
                                    {{ __('Información del Perfil') }}
                                </h2>
                                <p class="mt-1 text-sm text-muted">
                                    {{ __("Actualiza la información del perfil de tu cuenta y la dirección de correo electrónico.") }}
                                </p>
                            </header>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                                @csrf
                                @method('patch')

                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-sm text-muted">
                                                {{ __('Tu dirección de correo electrónico no está verificada.') }}
                                                <button form="send-verification"
                                                    class="btn btn-link p-0 text-decoration-none">
                                                    {{ __('Haz clic aquí para volver a enviar el correo de verificación.') }}
                                                </button>
                                            </p>
                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 text-success">
                                                    {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>

                                    @if (session('status') === 'profile-updated')
                                        <p class="text-success text-sm">
                                            {{ __('Guardado.') }}
                                        </p>
                                    @endif
                                </div>
                            </form>
                        </section>

                        <hr class="my-4">
                        <section class="container mt-5">
                            <header>
                                <h2 class="text-lg font-medium text-dark">
                                    {{ __('Actualizar Contraseña') }}
                                </h2>
                                <p class="mt-1 text-sm text-muted">
                                    {{ __('Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantener la seguridad.') }}
                                </p>
                            </header>

                            <form method="post" action="{{ route('password.update') }}" class="mt-4">
                                @csrf
                                @method('put')

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">{{ __('Contraseña Actual') }}</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        autocomplete="current-password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirmar Contraseña') }}</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        autocomplete="new-password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>

                                    @if (session('status') === 'password-updated')
                                        <p class="text-success text-sm">
                                            {{ __('Guardado.') }}
                                        </p>
                                    @endif
                                </div>
                            </form>
                        </section>

                        <hr class="my-4">
                        <section class="container mt-5">
                            <header>
                                <h2 class="text-lg font-medium text-dark">
                                    {{ __('Eliminar Cuenta') }}
                                </h2>
                                <p class="mt-1 text-sm text-muted">
                                    {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos se borrarán permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.') }}
                                </p>
                            </header>

                            <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal"
                                data-bs-target="#confirmUserDeletion">
                                {{ __('Eliminar Cuenta') }}
                            </button>

                            <div class="modal fade" id="confirmUserDeletion" tabindex="-1"
                                aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="confirmUserDeletionLabel">
                                                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-muted">
                                                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos se borrarán permanentemente. Por favor, introduce tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
                                            </p>
                                            <form method="post" action="{{ route('profile.destroy') }}" class="mt-4">
                                                @csrf
                                                @method('delete')

                                                <div class="mb-3">
                                                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="{{ __('Contraseña') }}">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-secondary me-2"
                                                        data-bs-dismiss="modal">
                                                        {{ __('Cancelar') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        {{ __('Eliminar Cuenta') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
