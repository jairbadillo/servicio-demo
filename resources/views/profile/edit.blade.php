@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
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
                        <!-- Mostrar mensajes de éxito -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Formulario de edición del perfil -->
                        <section class="container mt-5">
                            <header>
                                <h2 class="text-lg font-medium text-dark">
                                    {{ __('Profile Information') }}
                                </h2>
                                <p class="mt-1 text-sm text-muted">
                                    {{ __("Update your account's profile information and email address.") }}
                                </p>
                            </header>

                            <!-- Formulario para enviar el correo de verificación -->
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <!-- Formulario para actualizar la información del perfil -->
                            <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                                @csrf
                                @method('patch')

                                <!-- Campo de Nombre -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Correo Electrónico -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Mensaje si el correo no está verificado -->
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-sm text-muted">
                                                {{ __('Your email address is unverified.') }}
                                                <button form="send-verification"
                                                    class="btn btn-link p-0 text-decoration-none">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>
                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 text-success">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Botón de Guardar y Mensaje de Éxito -->
                                <div class="d-flex align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                                    <!-- Mensaje de éxito -->
                                    @if (session('status') === 'profile-updated')
                                        <p class="text-success text-sm">
                                            {{ __('Saved.') }}
                                        </p>
                                    @endif
                                </div>
                            </form>
                        </section>

                        <!-- Sección para cambiar la contraseña -->
                        <hr class="my-4">
                        <section class="container mt-5">
                            <header>
                                <h2 class="text-lg font-medium text-dark">
                                    {{ __('Update Password') }}
                                </h2>
                                <p class="mt-1 text-sm text-muted">
                                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                </p>
                            </header>

                            <form method="post" action="{{ route('password.update') }}" class="mt-4">
                                @csrf
                                @method('put')

                                <!-- Campo de Contraseña Actual -->
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        autocomplete="current-password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Nueva Contraseña -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('New Password') }}</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo de Confirmación de Contraseña -->
                                <div class="mb-3">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        autocomplete="new-password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botón de Guardar y Mensaje de Éxito -->
                                <div class="d-flex align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                                    <!-- Mensaje de éxito -->
                                    @if (session('status') === 'password-updated')
                                        <p class="text-success text-sm">
                                            {{ __('Saved.') }}
                                        </p>
                                    @endif
                                </div>
                            </form>
                        </section>

                        <!-- Botón para eliminar cuenta -->
                        <hr class="my-4">
                        <section class="container mt-5">
                            <header>
                                <h2 class="text-lg font-medium text-dark">
                                    {{ __('Delete Account') }}
                                </h2>
                                <p class="mt-1 text-sm text-muted">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                                </p>
                            </header>

                            <!-- Botón para abrir el modal -->
                            <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal"
                                data-bs-target="#confirmUserDeletion">
                                {{ __('Delete Account') }}
                            </button>

                            <!-- Modal de confirmación -->
                            <div class="modal fade" id="confirmUserDeletion" tabindex="-1"
                                aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="confirmUserDeletionLabel">
                                                {{ __('Are you sure you want to delete your account?') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-muted">
                                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                            </p>
                                            <form method="post" action="{{ route('profile.destroy') }}" class="mt-4">
                                                @csrf
                                                @method('delete')

                                                <!-- Campo de contraseña -->
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="{{ __('Password') }}">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Botones de acción -->
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-secondary me-2"
                                                        data-bs-dismiss="modal">
                                                        {{ __('Cancel') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        {{ __('Delete Account') }}
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
