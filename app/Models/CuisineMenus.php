<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\CuisineMenus.
 *
 * @property int                                                                              $id
 * @property int                                                                              $restaurant_id
 * @property int                                                                              $cuisine_category_id
 * @property string                                                                           $menu
 * @property string                                                                           $description
 * @property string                                                                           $delivery_time
 * @property string                                                                           $price
 * @property string                                                                           $sales_price
 * @property null|string                                                                      $sales_start
 * @property null|string                                                                      $sales_end
 * @property string                                                                           $toppings
 * @property null|\Illuminate\Support\Carbon                                                  $created_at
 * @property null|\Illuminate\Support\Carbon                                                  $updated_at
 * @property \App\Models\CuisineCategory                                                      $category
 * @property \App\Models\CuisineMenusExtras[]|\Illuminate\Database\Eloquent\Collection        $extras
 * @property null|int                                                                         $extras_count
 * @property Media[]|\Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection $media
 * @property null|int                                                                         $media_count
 * @property \App\Models\Restaurant                                                           $restaurant
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus query()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereCuisineCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereSalesEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereSalesPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereSalesStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereToppings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CuisineMenus extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $guarded = [];
    protected $table = 'cuisine_menus';

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function extras()
    {
        return $this->hasMany('App\Models\CuisineMenusExtras');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\CuisineCategory');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('menu')->singleFile();
    }


    public function getExtraAttribute(){

        return ($this->toppings) ? json_decode($this->toppings, true) : null;
    }
}
