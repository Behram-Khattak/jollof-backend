<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Consumable.
 *
 * @property int                                                                              $id
 * @property int                                                                              $restaurant_id
 * @property null|string                                                                      $name
 * @property null|string                                                                      $type
 * @property null|string                                                                      $price
 * @property null|\Illuminate\Support\Carbon                                                  $created_at
 * @property null|\Illuminate\Support\Carbon                                                  $updated_at
 * @property \App\Models\CuisineMenus[]|\Illuminate\Database\Eloquent\Collection              $extra
 * @property null|int                                                                         $extra_count
 * @property Media[]|\Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection $media
 * @property null|int                                                                         $media_count
 * @property null|\App\Models\CuisineMenus                                                    $menu
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consumable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Consumable extends Model implements HasMedia
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

    public function menu()
    {
        return $this->hasOne('App\Models\CuisineMenus');
    }

    public function extra()
    {
        //return $this->belongsTo('App\Models\CuisineMenusExtras');
        return $this->hasMany('App\Models\CuisineMenus', 'consumable_id');
    }
}
