<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingAddress extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
