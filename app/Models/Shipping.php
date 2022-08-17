<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Shipping.
 *
 * @property int                             $id
 * @property null|int                        $user_id
 * @property null|int                        $order_id
 * @property null|string                     $first_name
 * @property null|string                     $last_name
 * @property null|string                     $address
 * @property null|string                     $email
 * @property null|string                     $phone
 * @property null|string                     $city
 * @property null|string                     $state
 * @property null|string                     $default
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|\App\Models\Orders         $order
 * @property null|Shipping                   $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereUserId($value)
 * @mixin \Eloquent
 */
class Shipping extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    protected $table = 'shipping';

    public function order()
    {
        return $this->belongsTo('App\Models\Orders');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Shipping');
    }
}
