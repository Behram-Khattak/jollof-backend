<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class MediaLibraryCustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return Str::plural(strtolower(class_basename($media->model_type)))."/{$media->collection_name}/{$media->id}/";
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'responsives/';
    }
}
