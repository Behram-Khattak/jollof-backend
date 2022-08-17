<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\FashionProductSizeType.
 *
 * @property int                             $id
 * @property string                          $name
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FashionProductSizeType extends Model
{
    use QueryCacheable;

    protected $cacheFor = 604800;
    
}
