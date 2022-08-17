<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BusinessLocation.
 *
 * @property int                             $id
 * @property int                             $business_id
 * @property null|string                     $telephone
 * @property null|string                     $whatsapp
 * @property string                          $state
 * @property string                          $city
 * @property null|string                     $area
 * @property string                          $address
 * @property bool                            $default
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \App\Models\Business            $business
 * @property null|\App\Models\Team           $team
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessLocation whereWhatsapp($value)
 * @mixin \Eloquent
 */
class BusinessLocation extends Model
{
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * A business location belongs to a business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function team()
    {
        return $this->hasOne(Team::class, 'location_id');
    }
}
