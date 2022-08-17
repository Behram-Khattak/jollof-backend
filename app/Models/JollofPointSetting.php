<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JollofPointSetting extends Model
{
    protected $fillable = ['amount_per_point'];

    protected $table = 'jollofpointsettings';
}
