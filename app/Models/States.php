<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\States.
 *
 * @property int                                                          $id
 * @property string                                                       $state
 * @property null|string                                                  $status
 * @property null|\Illuminate\Support\Carbon                              $created_at
 * @property null|\Illuminate\Support\Carbon                              $updated_at
 * @property \App\Models\Areas[]|\Illuminate\Database\Eloquent\Collection $areas
 * @property null|int                                                     $areas_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|States newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|States newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|States query()
 * @method static \Illuminate\Database\Eloquent\Builder|States whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class States extends Model
{
    protected $guarded = [];

    public function areas()
    {
        return $this->hasMany('App\Models\Areas');
    }
}
