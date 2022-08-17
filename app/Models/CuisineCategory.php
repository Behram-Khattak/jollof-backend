<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CuisineCategory.
 *
 * @property int                                                                 $id
 * @property int                                                                 $restaurant_id
 * @property string                                                              $name
 * @property null|\Illuminate\Support\Carbon                                     $created_at
 * @property null|\Illuminate\Support\Carbon                                     $updated_at
 * @property \App\Models\CuisineMenus[]|\Illuminate\Database\Eloquent\Collection $menus
 * @property null|int                                                            $menus_count
 * @property \App\Models\Restaurant                                              $restuarant
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CuisineCategory extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'cuisine_category';

    public function restuarant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function menus()
    {
        return $this->hasMany('App\Models\CuisineMenus', 'cuisine_category_id');
    }
}
