@extends('dashboard')

@section('registerContent')
    {{-- <div class="d-flex align-items-center">
        <label for="date_act" class="fw-bold me-2">Fecha: </label>
        <select class="form-select fw-bold" id="date_act" name="date_act">
            <option value="2025" selected>2025</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>
    </div> --}}

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
                {{ $register->balance }}
            </td>
            <td class="text-center">
                <span class="badge {{ config('estados.colores')[$register->status] }}">{{ config('estados.lista')[$register->status] }}</span>
            </td>
            {{-- <td class="text-center">
                <div class="btn-group" role="group">
                    <a class="btn btn-success" href="{{ route('register.edit', $register->id) }}" role="button"><i class="bi bi-pencil-fill"></i></a>
                    <form method="POST" action="{{ route('register.destroy', $register->id) }}" style="margin-left: -4px;">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding-left: 16px;" onclick="return confirm('¿Estás seguro de eliminar este registro?');"><i class="bi bi-trash3-fill"></i></button>
                    </form>
                </div>
            </td> --}}
        </tr>
    @endforeach
@endsection