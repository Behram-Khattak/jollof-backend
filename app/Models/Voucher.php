<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Voucher.
 *
 * @property int                                                                                                                           $id
 * @property null|string                                                                                                                   $title
 * @property null|string                                                                                                                   $description
 * @property null|string                                                                                                                   $redemption_details
 * @property null|string                                                                                                                   $valid_for
 * @property null|string                                                                                                                   $location
 * @property string                                                                                                                        $status
 * @property null|string                                                                                                                   $start_date
 * @property null|string                                                                                                                   $expire_date
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereRedemptionDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereValidFor($value)
 * @mixin \Eloquent
 */
class Voucher extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
