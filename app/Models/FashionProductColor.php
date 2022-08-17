<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\FashionProductColor.
 *
 * @property int                             $id
 * @property string                          $name
 * @property null|string                     $hex_code
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor query()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor whereHexCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductColor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FashionProductColor extends Model
{

    use QueryCacheable;

    protected $cacheFor = 604800;
}
