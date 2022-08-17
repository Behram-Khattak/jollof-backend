<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Restaurant.
 *
 * @property int                                                                              $id
 * @property int                                                                              $business_id
 * @property null|int                                                                         $business_location_id
 * @property null|string                                                                      $min_order
 * @property null|string                                                                      $disposable
 * @property null|string                                                                      $delivery_fee
 * @property null|string                                                                      $delivery_time
 * @property null|string                                                                      $delivery_options
 * @property null|string                                                                      $payment_types
 * @property null|string                                                                      $featured
 * @property null|string                                                                      $hours
 * @property string                                                                           $default_setup
 * @property null|string                                                                      $status
 * @property null|\Illuminate\Support\Carbon                                                  $created_at
 * @property null|\Illuminate\Support\Carbon                                                  $updated_at
 * @property \App\Models\Business                                                             $business
 * @property \App\Models\CuisineCategory[]|\Illuminate\Database\Eloquent\Collection           $category
 * @property null|int                                                                         $category_count
 * @property Media[]|\Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection $media
 * @property null|int                                                                         $media_count
 * @property \App\Models\Consumable[]|\Illuminate\Database\Eloquent\Collection                $menus
 * @property null|int                                                                         $menus_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereBusinessLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereDefaultSetup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereDeliveryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereDeliveryOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereDisposable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereMinOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant wherePaymentTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Restaurant extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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

    public function menus()
    {
        return $this->hasManyThrough(
            'App\Models\Consumable',
            'App\Models\CuisineMenus',
            'restaurant_id', // Foreign key on users table...
                'id', // Foreign key on posts table...
                'id', // Local key on countries table...
                'id' // Local key on users table...
        );
    }


    public function category()
    {
        return $this->hasMany('App\Models\CuisineCategory');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    public function locations()
    {
        return $this->belongsTo('App\Models\BusinessLocation', 'business_location_id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Bookings', 'restaurant_id');
    }
}
