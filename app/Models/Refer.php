<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refer extends Model
{
    protected $guarded = [];

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
