<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Areas.
 *
 * @property int                             $id
 * @property int                             $states_id
 * @property null|string                     $area
 * @property null|string                     $status
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \App\Models\States              $state
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Areas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Areas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Areas query()
 * @method static \Illuminate\Database\Eloquent\Builder|Areas whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Areas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Areas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Areas whereStatesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Areas whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Areas whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Areas extends Model
{
    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo('App\Models\States');
    }


    public function shipping()
    {
        return $this->hasMany('App\Models\ShippingGroup', 'area_id');
    }
}
