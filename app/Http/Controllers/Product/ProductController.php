<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $data['product_category_id'] = intval($data['product_category_id']); 
            $product = new Product($data);

            $product->save();
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
                'message' => 'Ocurrió un error al crear el producto.',
                'errors' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'data' => $product,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
