<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{

    use SoftDeletes;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->BelongsTo(Orders::class);
    }
}
