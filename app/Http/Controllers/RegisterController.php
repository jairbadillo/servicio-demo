<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dato = 'Paso 2';
        // return view('register', ['registers' => $dato]);

        $maxDate = Register::selectRaw('MAX(date_expiration) as max_date')->value('max_date');

        $maxMonth = date('m', strtotime($maxDate));
        $maxYear = date('Y', strtotime($maxDate));

        $registers = Register::select('id', 'name', 'date_expiration', 'balance', 'status')
                            ->selectRaw('MONTHNAME(date_expiration) as date_name')
                            ->whereMonth('date_expiration', $maxMonth)
                            ->whereYear('date_expiration', $maxYear)
                            ->get();

        $totalBalance = $registers->where('status', '!=', 're')
                                ->sum('balance');

        return view('register', compact('registers', 'totalBalance'));
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
            'name' => 'required',
            'date_expiration' => 'required',
            'balance' => 'required',
            'status' => 'required|not_in:ninguno'
        ],
        [
            'name.required' => 'El campo nombre es requerido.',
            'date_expiration.required' => 'El campo fecha de vencimiento es requerido.',
            'balance.required' => 'Debes colocar algun saldo.',
            'status.required' => 'Debes seleccionar una opción válida.',
            'status.not_in' => 'La opción seleccionada no es válida.',
        ]);

        Register::create($validated);

        return redirect()->route('dashboard')
                            ->with('success', 'Registro creado exitosamente');
    }

        /**
     * Store a newly created and duplicate resource in storage.
     */
    public function duplicate()
    {

        // Subconsulta para obtener la fecha de expiración más reciente
        $maxDate = Register::selectRaw('MAX(date_expiration) as max_date')->value('max_date');

        // Extraer el mes y año de la fecha más reciente
        $maxMonth = date('m', strtotime($maxDate));
        $maxYear = date('Y', strtotime($maxDate));

        // Consulta principal
        $duplicados = Register::select('name', 'balance')
                            ->selectRaw("DATE_ADD(date_expiration, INTERVAL 1 MONTH) as date_expiration") // Aplicar DATE_ADD
                            ->selectRaw("'pe' as status") // Agregar el campo "status" con valor fijo
                            ->whereMonth('date_expiration', $maxMonth) // Filtrar por mes
                            ->whereYear('date_expiration', $maxYear)   // Filtrar por año
                            ->get();

        // Conversión a array: La colección se convierte a un array de arrays usando toArray().
        // Insertar datos: El método insert() recibe un array de arrays y los inserta en la tabla.
        Register::insert($duplicados->toArray());

        return redirect()->route('dashboard')
                            ->with('success', 'Se duplicaron los registros con éxito');
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
                            ->with('success', 'Registro modificado exitosamente');
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
                                ->with('success', 'Registro eliminado exitosamente');
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
                                ->with('success', 'Registros eliminados exitosamente');
        }
    }

    /**
     * History resource from storage.
     */
    public function loghistory()
    {
        $registers = Register::orderBy('date_expiration', 'desc')->get();

        return view('logHistory', compact('registers'));
    }
}
