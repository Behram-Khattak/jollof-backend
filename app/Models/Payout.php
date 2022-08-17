<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $guarded = [];


    public function requests(){
        return $this->hasMany(PayoutRequest::class);
    }


    public function business(){
        return $this->belongsTo(Business::class);
    }
}
