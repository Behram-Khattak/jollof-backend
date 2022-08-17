<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Orders.
 *
 * @property int                                                               $id
 * @property null|int                                                          $user_id
 * @property string                                                            $order_code
 * @property null|string                                                       $shipment_is
 * @property null|int                                                          $shipping_id
 * @property null|string                                                       $shipping_info
 * @property null|string                                                       $status
 * @property float                                                             $subtotal
 * @property float                                                             $total
 * @property null|\Illuminate\Support\Carbon                                   $created_at
 * @property null|\Illuminate\Support\Carbon                                   $updated_at
 * @property \App\Models\OrderItems[]|\Illuminate\Database\Eloquent\Collection $items
 * @property null|int                                                          $items_count
 * @property null|\App\Models\Shipping                                         $shipping
 * @property null|\App\Models\User                                             $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Orders newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders query()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereShipmentIs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereShippingInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereUserId($value)
 * @mixin \Eloquent
 */
class Orders extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('App\Models\OrderItems', 'order_id');
    }

    public function shipping()
    {
        return $this->hasOne('App\Models\Shipping', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function transaction()
    {
        return $this->hasOne('App\Models\Flutterwave', 'order_code', 'order_code');
    }

    public function product()
    {
        return $this->belongsTo(FashionProduct::class, 'product_id');
    }
}
