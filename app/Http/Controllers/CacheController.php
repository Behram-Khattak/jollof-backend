<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function clear()
    {
        Artisan::call('clear:all');
        return "All cache cleared";
    }
}
