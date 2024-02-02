<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\StoreBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todas las sucursales
        $branches = Branch::all();
        // Puedes devolver las sucursales como una respuesta JSON
        return response()->json(['branches' => $branches]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        // Valida y obtiene los datos validados
        $validatedData = $request->validated();

        // Crea una nueva instancia de la sucursal con los datos validados
        $branch = new Branch($validatedData);

        // Guarda la sucursal en la base de datos
        $branch->save();

        // Puedes devolver una respuesta o redirigir a otra página
        return response()->json(['message' => 'Sucursal creada con éxito'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
