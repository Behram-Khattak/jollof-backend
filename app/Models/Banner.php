<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Banner.
 *
 * @property int                                                                              $id
 * @property string                                                                           $title
 * @property null|string                                                                      $microsite
 * @property null|string                                                                      $slot
 * @property string                                                                           $file_url
 * @property null|string                                                                      $link
 * @property string                                                                           $location
 * @property int                                                                              $days
 * @property string                                                                           $banner_type
 * @property string                                                                           $can_view
 * @property string                                                                           $start_date
 * @property string                                                                           $expiry_date
 * @property null|string                                                                      $price
 * @property string                                                                           $status
 * @property null|\Illuminate\Support\Carbon                                                  $created_at
 * @property null|\Illuminate\Support\Carbon                                                  $updated_at
 * @property Media[]|\Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection $media
 * @property null|int                                                                         $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereBannerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCanView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereMicrosite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereSlot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Banner extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the user's images.
     */
    // public function media()
    // {
    //     return $this->morphMany(Media::class, 'models');
    // }

    // public function registerMediaConversions(Media $media = null)
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('square')
            ->width(412)
            ->height(412)
            ->sharpen(10);
    }
}
