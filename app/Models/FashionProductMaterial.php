<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\FashionProductMaterial.
 *
 * @property int                             $id
 * @property string                          $name
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductMaterial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FashionProductMaterial extends Model
{
    // use QueryCacheable;

    // protected $cacheFor = 604800;
}
