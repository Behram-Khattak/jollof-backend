<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookings extends Model
{
    protected $guarded = [];

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant');
    }
}
