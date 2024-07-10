<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductRequest;
use App\Http\Services\Product\CreateProductService;
use App\Http\Services\Product\DeleteProductService;
use App\Http\Services\Product\QueryProductService;
use App\Http\Services\Product\UpdateProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        Gate::authorize('create', Product::class);

        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'value' => 'required|decimal:8,2',
                'establishment_id' => 'required|int',
            ]);

            DB::beginTransaction();

            $service = new CreateProductService();

            $product = $service->create($validated);

            DB::commit();

            return $product;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        Gate::authorize('update', Product::class);

        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'value' => 'required|decimal:8,2',
                'establishment_id' => 'required|int',
            ]);

            DB::beginTransaction();

            $service = new UpdateProductService();

            $updated = $service->update($validated, $id);

            DB::commit();

            return $updated;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function delete(int $id)
    {
        Gate::authorize('delete', Product::class);

        try {
            DB::beginTransaction();

            $service = new DeleteProductService();

            $service->delete($id);

            DB::commit();

            return response()->json([
                'message' => 'Produto excluído com sucesso!'
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function getProducts(Request $request)
    {
        $service = new QueryProductService();

        return $service->getProducts($request->all());
    }

    public function getProductById(int $id)
    {
        $service = new QueryProductService();

        return $service->getProductById($id);
    }

    public function createWithMedias(ProductRequest $request)
    {
        Gate::authorize('create', Product::class);

        try {
            DB::beginTransaction();

            $service = new CreateProductService();

            $product = $service->createWithMedias($request->all());

            DB::commit();

            return $product;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }
}
