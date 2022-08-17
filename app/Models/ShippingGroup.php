<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingGroup extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function area()
    {
        return $this->belongsTo('App\Models\Areas');
    }
}
