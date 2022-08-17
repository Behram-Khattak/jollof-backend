<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    protected $guarded = [];

    public function payout(){
        return $this->belongsTo(Payout::class);
    }
}
