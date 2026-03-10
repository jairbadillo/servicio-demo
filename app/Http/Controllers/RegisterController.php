<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        Carbon::setLocale('es');

        // 1. Obtener la última fecha registrada (solo el campo necesario)
        $fechaDb = Register::latest('date_expiration')
            ->select('date_expiration')
            ->first();

        if (!$fechaDb) {
            return view('register', [
                'registers' => collect(),
                'totalBalance' => 0,
                'mesEspanol' => null
            ]);
        }

        // 2. Mes en español (primera letra mayúscula)
        $mesEspanol = Str::ucfirst(
            $fechaDb->date_expiration->translatedFormat('F')
        );

        // 3. Rango del mes (usa índice)
        $inicioMes = $fechaDb->date_expiration->copy()->startOfMonth();
        $finMes = $fechaDb->date_expiration->copy()->endOfMonth();

        // 4. Obtener registros del mes
        $registers = Register::select('id','name','date_expiration','balance','status')
                            ->whereBetween('date_expiration', [$inicioMes, $finMes])
                            ->orderBy('date_expiration')
                            ->get();

        // 5. Total optimizado (calculado en BD)
        $sumarBalance = Register::whereBetween('date_expiration', [$inicioMes, $finMes])
                            ->where('status', '!=', 're')
                            ->sum('balance');

        $totalBalance = number_format($sumarBalance, 2, ',', '.');

        // 6. Vista
        return view('register', compact('registers', 'totalBalance', 'mesEspanol'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('formCreateRegister');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_expiration' => 'required|date',
            'balance' => 'required|numeric|min:0|max:99999999.99',
            'status' => 'required|not_in:ninguno'
        ],
        [
            'name.required'             => 'El campo nombre es requerido.',
            'date_expiration.required'  => 'El campo fecha de vencimiento es requerido.',
            'balance.required'          => 'Debes colocar algún saldo.',
            'balance.min'               => 'El saldo no puede ser negativo.',
            'balance.max'               => 'El saldo no puede superar 99,999,999.99',
            'status.required'           => 'Debes seleccionar una opción válida.',
            'status.not_in'             => 'La opción seleccionada no es válida.',
        ]);

        Register::create($validated);

        return redirect()->route('dashboard')
                            ->with('swal', [
                                'icon'  => 'success',
                                'title' => '¡Correcto!',
                                'text'  => 'Registro creado exitosamente.',
                            ]);
    }

        /**
     * Store a newly created and duplicate resource in storage.
     */
    public function duplicate()
    {
        // 1. Obtener la última fecha registrada
        $fechaDb = Register::latest('date_expiration')
            ->select('date_expiration')
            ->first();

        // 2. Rango del mes más reciente
        $inicioMes = $fechaDb->date_expiration->copy()->startOfMonth();
        $finMes = $fechaDb->date_expiration->copy()->endOfMonth();

        // 3. Duplicar registros sumándoles un mes
        Register::insertUsing(
            ['name', 'balance', 'date_expiration', 'status'],
            Register::select('name', 'balance')
                ->selectRaw("DATE_ADD(date_expiration, INTERVAL 1 MONTH)")
                ->selectRaw("'pe'")
                ->whereBetween('date_expiration', [$inicioMes, $finMes])
        );

        return redirect()->route('dashboard')
                            ->with('swal', [
                                'icon'  => 'success',
                                'title' => '¡Correcto!',
                                'text'  => 'Registro duplicado con éxíto.',
                            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $registers = Register::find($id);
        return view('formEditRegister', compact('registers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registers = Register::find($id);

        // $registers->nombre = $request->nombre;
        // $registers->fecha = $request->fecha;
        // $registers->categoria = $request->categoria;
        // $registers->descripcion = $request->descripcion;

        // $registers->save();

        $registers->update($request->all());

        return redirect()->route('dashboard')
                            ->with('swal', [
                                'icon'  => 'success',
                                'title' => '¡Correcto!',
                                'text'  => 'Registro modificado exitosamente.',
                            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        {
            $registers = Register::find($id);
            $registers->delete();
    
            return redirect()->route('dashboard')
                                ->with('swal', [
                                    'icon'  => 'success',
                                    'title' => '¡Eliminado!',
                                    'text'  => 'Registro eliminado exitosamente.',
                                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletetable()
    {
        {
            $maxDate = Register::selectRaw('MAX(date_expiration) as max_date')->value('max_date');

            $maxMonth = date('m', strtotime($maxDate));
            $maxYear = date('Y', strtotime($maxDate));

            $registers = Register::whereMonth('date_expiration', $maxMonth)
                                ->whereYear('date_expiration', $maxYear)
                                ->get();

            $registers->each->delete();
    
            return redirect()->route('dashboard')
                                ->with('swal', [
                                    'icon'  => 'success',
                                    'title' => '¡Eliminado!',
                                    'text'  => 'Registro eliminado exitosamente.',
                                ]);
        }
    }

    /**
     * History resource from storage.
     */
    public function loghistory($anio = null)
    {
        $year = $anio ?? now()->year;

        $registers = Register::whereYear('date_expiration', $year)
            ->orderBy('date_expiration', 'desc')
            ->get()
            ->groupBy(fn($r) => Carbon::parse($r->date_expiration)->format('Y-m'));

        $monthlyTotals = Register::selectRaw("
                DATE_FORMAT(date_expiration, '%Y-%m') as month,
                SUM(balance) as total_balance,
                COUNT(*) as total_records
            ")
            ->where('status', '!=', 're')
            ->whereYear('date_expiration', $year)
            ->groupByRaw("DATE_FORMAT(date_expiration, '%Y-%m')")
            ->orderBy('month', 'desc')
            ->get()
            ->keyBy('month');

        $availableYears = Register::selectRaw('YEAR(date_expiration) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Preparamos los labels de mes ya formateados para no usar Carbon en la vista
        $monthLabels = $registers->keys()->mapWithKeys(fn($month) => [
            $month => Carbon::createFromFormat('Y-m', $month)
                        ->locale('es')
                        ->translatedFormat('F Y')
        ]);

        return view('logHistory', compact('registers', 'monthlyTotals', 'availableYears', 'year', 'monthLabels'));
    }
}
