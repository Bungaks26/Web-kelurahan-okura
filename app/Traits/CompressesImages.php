<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

trait CompressesImages
{
    protected function storeCompressedImage(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1280,
        int $quality = 75
    ): string {
        $manager = new ImageManager(new Driver());

        $image = $manager->decode(
            file_get_contents($file->getRealPath())
        );

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $filename = $folder . '/' . Str::random(20) . '.webp';
        $fullPath = storage_path('app/public/' . $filename);

        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $image
            ->encode(new WebpEncoder(quality: $quality))
            ->save($fullPath);

        return $filename;
    }
}