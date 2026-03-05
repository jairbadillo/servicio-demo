@extends('dashboard')

@section('title-card')
    {{ $mesEspanol }}
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
                {{ $register->date_expiration_formatted }}
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
                    <form id="form-delete-{{ $register->id }}" method="POST" action="{{ route('register.destroy', $register->id) }}" style="margin-left: -4px;">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-danger" style="padding-left: 16px;" onclick="confirmarUnaEliminar('{{ $register->id }}', '{{ $register->name }}')"><i class="bi bi-trash3-fill"></i></button>
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
            <strong>{{ $totalBalance }}</strong>
        </td>
    </tr>
@endsection

@push('scripts')
    <script>
        function confirmarUnaEliminar(id, name) {
            Swal.fire({
                title: '¿Eliminar registro?',
                text: 'El servicio ' + name + ' será eliminado permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                focusCancel: true,
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            });
        }
    </script>
@endpush