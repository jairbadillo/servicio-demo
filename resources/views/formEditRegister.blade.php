@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
@endsection

@section('layoutContent')

    <div class="d-flex align-items-center mx-auto rounded shadow m-4 p-3 col-12 col-md-10 col-lg-6" style="height: 5rem; background-color: white;">
        <a class="btn btn-secondary" href="{{ route('dashboard') }}" role="button"><i class="bi bi-arrow-90deg-left"></i> Volver</a>
    </div>

    <div class="card mx-auto shadow m-4" style="max-width: 30rem;">
        <div class="card-header bg-transparent font-bold fs-3">Formulario</div>
            <div class="card-body">
                <h3 class="card-title">Editando el servicio: <b> {{ $registers->id }} </b></h3>
                <form method="POST" action="{{ route('register.update', $registers->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del servicio..." value="{{ $registers->name }}"/>
                        <label for="name">Nombre</label>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="date" class="form-control" id="date_expiration" name="date_expiration" placeholder="Fecha de vencimiento..." value="{{ $registers->date_expiration }}"/>
                        <label for="date_expiration">Fecha de Vencimiento</label>
                        @error('date_expiration')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="number" class="form-control" id="balance" name="balance" placeholder="Saldo..." value="{{ $registers->balance }}"/>
                        <label for="balance">Saldo</label>
                        @error('balance')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" id="status" name="status">
                            @foreach(config('estados.lista') as $codigo => $nombre)
                                <option value="{{ $codigo }}" {{ $registers->status == $codigo ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <label for="status">Estado</label>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection