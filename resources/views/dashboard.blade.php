@extends('layouts.app')

@section('header')
    @if (request()->routeIs('dashboard'))
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">{{ __('Dashboard') }}</h2>
    @else
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">{{ __('Historial') }}</h2>
    @endif
@endsection

@section('layoutContent')

    @if (request()->routeIs('dashboard'))
        @if(session('success'))
            <div id="alertSuccess" class="alert alert-success mx-auto m-4" style="width: 50rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between mx-auto rounded shadow mb-4 p-3 col-12 col-md-10 col-lg-6" style="height: 5rem; background-color: white;">
            <form method="POST" action="{{ route('register.duplicate') }}">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('¿Estás seguro de crear los registros del proximo mes?');"><i class="bi bi-calendar2-plus"></i> Crear proximo mes</button>
            </form>

            <form method="POST" action="{{ route('register.deletetable') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar los registros del mes presente?');"><i class="bi bi-calendar-x"></i> Eliminar este mes</button>
            </form>
        </div>
    @endif

    <div class="card mx-auto shadow col-12 col-md-10 col-lg-6">
        @if (request()->routeIs('dashboard'))
            <div class="card-header">
                <div class="row d-flex align-items-center">
                    <div class="col 4">
                        <a class="btn btn-primary" href="{{ route('register.create') }}" role="button"><i class="bi bi-plus-circle"></i> Agregar registro</a>
                    </div>
                    <div class="col 4 text-center">
                        <h2 class="mx-auto my-auto">@yield('title-card')</h2>
                    </div>
                    <div class="col 4">
                    </div>
                </div>
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Servicios</th>
                            <th scope="col" class="text-center">Fecha vencimientos</th>
                            <th scope="col" class="text-start">Saldo</th>
                            <th scope="col" class="text-center">Estado</th>
                            @if (request()->routeIs('dashboard'))
                                <th scope="col" class="text-center">Acción</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @yield('registerContent')
                    </tbody>
                    <tfoot>
                        @yield('registerContentFooter')
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

