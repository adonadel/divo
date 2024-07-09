<?php

namespace App\Http\Controllers;

use App\Http\Services\Media\CreateMediaService;
use App\Http\Services\Media\DeleteMediaService;
use App\Http\Services\Media\UpdateMediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class MediaController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'media' => [
                    'required', File::types(['jpg', 'jpeg', 'png'])
                ],
                'display_name' => 'nullable|string',
                'description' => 'nullable|string',
            ]);

            $service = new CreateMediaService();

            $media = $service->create($validated);

            DB::commit();

            return $media;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'media' => [
                    'nullable', File::types(['jpg', 'jpeg', 'png'])
                ],
                'display_name' => 'nullable|string',
                'description' => 'nullable|string',
            ]);

            $service = new UpdateMediaService();

            $media = $service->update($id, $validated);

            DB::commit();

            return $media;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            DB::beginTransaction();

            $service = new DeleteMediaService();

            $service->delete($id);

            DB::commit();

            return response()->json([
                'message' => 'Arquivo excluído com sucesso!'
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }


    public function bulkCreate(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'medias' => 'array|required',
                'medias.*.media' => [
                    'required', File::types(['jpg', 'jpeg', 'png'])
                ],
                'medias.*.display_name' => 'nullable|string',
                'medias.*.description' => 'nullable|string',
                'animal_id' => 'nullable|exists:animals,id',
            ]);

            $service = new CreateMediaService();

            $medias = $service->bulkCreate($validated);

            DB::commit();

            return $medias;
        }catch (\Exception $exception) {
            DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }
}
