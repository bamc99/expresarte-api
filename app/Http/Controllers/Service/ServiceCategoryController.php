<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceCategoryRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $category = new ServiceCategory($data);

            $category->save();
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
                'message' => 'Ocurrió un error al crear la categoria.',
                'errors' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Categoria creada exitosamente',
            'data' => $category,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        //
    }
}
