<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CuisineMenusExtras.
 *
 * @property int                                                               $id
 * @property int                                                               $cuisine_menus_id
 * @property int                                                               $consumables_id
 * @property null|\Illuminate\Support\Carbon                                   $created_at
 * @property null|\Illuminate\Support\Carbon                                   $updated_at
 * @property \App\Models\Consumable[]|\Illuminate\Database\Eloquent\Collection $consumables
 * @property null|int                                                          $consumables_count
 * @property \App\Models\CuisineMenus                                          $extras
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras query()
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras whereConsumablesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras whereCuisineMenusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CuisineMenusExtras whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CuisineMenusExtras extends Model
{
    protected $guarded = [];

    public function extras()
    {
        return $this->belongsTo(CuisineMenus::class, 'cuisine_menus_id');
    }

    public function consumables()
    {
        return $this->hasMany(Consumable::class, 'consumables_id');
    }
}
