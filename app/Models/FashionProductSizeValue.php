<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\FashionProductSizeValue.
 *
 * @property int                             $id
 * @property string                          $name
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeValue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProductSizeValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FashionProductSizeValue extends Model
{
    use QueryCacheable;

    protected $cacheFor = 604800;
}
