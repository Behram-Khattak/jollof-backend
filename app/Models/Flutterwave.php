<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Flutterwave.
 *
 * @property int                             $id
 * @property null|string                     $order_code
 * @property null|string                     $reference
 * @property null|int                        $transaction_id
 * @property null|string                     $email
 * @property null|int                        $amount
 * @property null|string                     $status
 * @property null|string                     $gateway_response
 * @property null|string                     $ip_address
 * @property null|string                     $card_type
 * @property null|int                        $last4
 * @property null|int                        $exp_month
 * @property null|int                        $exp_year
 * @property null|string                     $bank
 * @property null|string                     $channel
 * @property null|string                     $authorization_code
 * @property null|string                     $raw_response
 * @property null|string                     $completed_at
 * @property null|string                     $verified
 * @property null|string                     $verified_at
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave query()
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereAuthorizationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereExpMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereExpYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereGatewayResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereLast4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereRawResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flutterwave whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class Flutterwave extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'flutterwave';
}
