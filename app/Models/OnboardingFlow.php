<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OnboardingFlow.
 *
 * @property int                             $id
 * @property int                             $business_id
 * @property bool                            $profile
 * @property bool                            $kyc
 * @property bool                            $locations
 * @property bool                            $teams
 * @property bool                            $logo
 * @property bool                            $banner
 * @property int                             $completed
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow query()
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereKyc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereLocations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereTeams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnboardingFlow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OnboardingFlow extends Model
{
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'profile'   => 'boolean',
        'kyc'       => 'boolean',
        'locations' => 'boolean',
        'teams'     => 'boolean',
        'logo'      => 'boolean',
        'banner'    => 'boolean',
        'completed' => 'boolean'
    ];
}
