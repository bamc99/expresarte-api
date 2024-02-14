<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        return response()->json([
            'services' => $services
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $service = new Service($data);
            $service->save();
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error de base de datos',
                'errors' => $e->getMessage()
            ], 500);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Ocurrió un error al crear el servicio.',
                'errors' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Servicio creado exitosamente',
            'data' => $service,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
