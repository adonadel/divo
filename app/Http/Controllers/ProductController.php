<?php

namespace App\Http\Controllers;

use App\Http\Services\Product\CreateProductService;
use App\Http\Services\Product\DeleteProductService;
use App\Http\Services\Product\QueryProductService;
use App\Http\Services\Product\UpdateProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'value' => 'required',
                'establishment_id' => 'required|int',
                'medias' => 'string|required',
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
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'value' => 'required|decimal:8,2',
                'establishment_id' => 'required|int',
                'medias' => 'nullable|array',
                'medias.*.media' => [
                    'required', File::types(['jpg', 'jpeg', 'png'])
                ],
                'medias.*.display_name' => 'nullable|string',
                'medias.*.description' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $service = new UpdateProductService();

            $updated = $service->update($id, $validated);

            DB::commit();

            return $updated;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function delete(int $id)
    {
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

    public function createWithMedias(Request $request)
    {
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
