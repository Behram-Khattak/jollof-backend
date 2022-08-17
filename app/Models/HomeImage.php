<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomeImage extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('homeblock')
            ->singleFile();
    }
}
