<?php

namespace App\Http\Services\Media;
use App\Repositories\EstablishmentMediaRepository;
use App\Repositories\MediaRepository;
use App\Repositories\ProductMediaRepository;
use Illuminate\Support\Facades\Storage;

class CreateMediaService
{

    public function create(array $data)
    {
        $repository = new MediaRepository();

        $data = $this->makeUpload($data);

        $media = $repository->create($data);

        return $media;
    }

    public function bulkCreate(array $data)
    {
        $allMedias = [];

        foreach ($data['medias'] as $media) {
            $allMedias[] = $this->create($media);
        }

        if (data_get($data, 'product_id')) {
            $productMediaRepository = new ProductMediaRepository();

            foreach ($allMedias as $media) {
                $productMediaRepository->create([
                    'product_id' => data_get($data, 'product_id'),
                    'media_id' => $media->id,
                ]);
            }
        }

        if (data_get($data, 'establishment_id')) {
            $establishmentMediaRepository = new EstablishmentMediaRepository();

            foreach ($allMedias as $media) {
                $establishmentMediaRepository->create([
                    'establishment_id' => data_get($data, 'establishment_id'),
                    'media_id' => $media->id,
                ]);
            }
        }

        return $allMedias;
    }

    public function makeUpload(array $data): array
    {
        $file = data_get($data, 'media');
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getClientMimeType();
        $imageDetails = getimagesize($file->getPathname());

        $data['extension'] = $extension;
        $data['size'] = $file->getSize();
        $data['width'] = $imageDetails[0];
        $data['height'] = $imageDetails[1];
        unset($data['media']);

        $filename = Storage::disk('google')->put('', $file, [
            'visibility' => 'public',
            'mimeType' => $mimeType,
        ]);

        $data['filename_id'] = data_get(
            Storage::disk('google')->getAdapter()->getMetadata($filename)->extraMetadata(),
            'id'
        );

        $data['filename'] = $filename;

        return $data;
    }
}
