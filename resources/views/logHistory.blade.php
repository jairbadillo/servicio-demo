@extends('dashboard')

@section('registerContent')

    <div class="d-flex align-items-center mb-3">
        <label for="year_select" class="fw-bold me-2">Año:</label>
        <select class="form-select fw-bold w-auto" id="year_select" name="year_select">
            @foreach ($availableYears as $availableYear)
                <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>
                    {{ $availableYear }}
                </option>
            @endforeach
        </select>
    </div>

    @foreach ($registers as $month => $monthRegisters)

        <tr class="table-dark">
            <td colspan="5" class="fw-bold text-uppercase">
                {{ $monthLabels[$month] }}
            </td>
        </tr>

        @foreach ($monthRegisters as $register)
            <tr>
                <td>{{ $register->id }}</td>
                <td>{{ $register->name }}</td>
                <td class="text-center">{{ $register->date_expiration }}</td>
                <td>{{ number_format($register->balance, 2) }}</td>
                <td class="text-center">
                    <span class="badge {{ config('estados.colores')[$register->status] }}">
                        {{ config('estados.lista')[$register->status] }}
                    </span>
                </td>
            </tr>
        @endforeach

        @if (isset($monthlyTotals[$month]))
            <tr class="table-info fw-bold border-top border-2">
                <td colspan="3" class="text-end">
                    Total {{ $monthLabels[$month] }} ({{ $monthlyTotals[$month]->total_records }} registros):
                </td>
                <td>{{ number_format($monthlyTotals[$month]->total_balance, 2) }}</td>
                <td></td>
            </tr>
        @endif

    @endforeach

@endsection

@push('scripts')
    <script>
        document.getElementById('year_select').addEventListener('change', function () {
            window.location.href = "{{ url('register') }}/" + this.value + "/loghistory";
        });
    </script>
@endpush