<?php

namespace App\Models;

use App\Models\FashionProduct;
use Illuminate\Database\Eloquent\Model;

class layaway extends Model
{
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(FashionProduct::class);
    }
}
