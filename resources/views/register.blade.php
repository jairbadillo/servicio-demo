@extends('dashboard')

@section('title-card')
    @php
        $meses = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre',
        ];

        $mes_espanol = $meses[$registers->first()->date_name ?? strftime("%B")];

        echo $mes_espanol;
    @endphp
@endsection

@section('registerContent')
    @foreach ($registers as $register)
        <tr>
            <td>
                {{ $register->id }}
            </td>
            <td>
                {{ $register->name }}
            </td>
            <td class="text-center">
                {{ $register->date_expiration }}
            </td>
            <td>
                {{ $register->balance_formatted }}
            </td>
            <td class="text-center">
                <span class="badge {{ config('estados.colores')[$register->status] }}">{{ config('estados.lista')[$register->status] }}</span>
            </td>
            <td class="text-center">
                <div class="btn-group" role="group">
                    <a class="btn btn-success" href="{{ route('register.edit', $register->id) }}" role="button"><i class="bi bi-pencil-fill"></i></a>
                    <form method="POST" action="{{ route('register.destroy', $register->id) }}" style="margin-left: -4px;">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding-left: 16px;" onclick="return confirm('¿Estás seguro de eliminar este registro?');"><i class="bi bi-trash3-fill"></i></button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
@endsection

@section('registerContentFooter')
    <tr>
        <td colspan="3" class="border-end text-end">
            <strong>Total</strong>
        </td>
        <td class="text-end">
            <strong>{{ number_format($totalBalance, 0, ',', '.') }}</strong>
        </td>
    </tr>
@endsection