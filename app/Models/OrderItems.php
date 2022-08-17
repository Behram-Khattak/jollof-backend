<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OrderItems.
 *
 * @property int                             $id
 * @property null|int                        $order_id
 * @property null|int                        $business_id
 * @property null|string                     $name
 * @property null|string                     $description
 * @property null|int                        $quantity
 * @property float                           $unit_price
 * @property float                           $total_price
 * @property string                          $status
 * @property null|string                     $process_timestamp
 * @property null|string                     $pickup_timestamp
 * @property null|string                     $delivery_timestamp
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|\App\Models\Orders         $order
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereDeliveryTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems wherePickupTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereProcessTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItems whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItems extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    public function scopeHasOrdered($query, $business_id, $user_id)
    {
        return $query->addSelect([
            'user_id' => Orders::select('user_id')
                ->whereColumn('order_id', 'orders.id')
                ->where('user_id', $user_id)
                ->latest()
                ->take(1)
        ])->where('business_id', $business_id);
    }

    public function scopeHasPaid($query)
    {
        return $query->addSelect([
            'paid' => Orders::where('order_id', 'orders.id')
                ->where('status', 'paid')
                ->latest()
                ->take(1)
        ]);
    }
}
