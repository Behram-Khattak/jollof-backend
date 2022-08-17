<?php

namespace App\Models;

use App\Enums\MediaCollectionNames;
use App\Notifications\VerifyEmail;
use App\Traits\IncludeTrashedTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mpociot\Teamwork\Traits\UserHasTeams;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;

/**
 * App\Models\User.
 *
 * @property int                                                                                                       $id
 * @property string                                                                                                    $first_name
 * @property string                                                                                                    $last_name
 * @property string                                                                                                    $username
 * @property string                                                                                                    $email
 * @property null|string                                                                                               $telephone
 * @property null|\Illuminate\Support\Carbon                                                                           $email_verified_at
 * @property null|string                                                                                               $password
 * @property null|string                                                                                               $remember_token
 * @property null|\Illuminate\Support\Carbon                                                                           $created_at
 * @property null|\Illuminate\Support\Carbon                                                                           $updated_at
 * @property null|\Illuminate\Support\Carbon                                                                           $deleted_at
 * @property null|int                                                                                                  $current_team_id
 * @property \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[]                                  $audits
 * @property null|int                                                                                                  $audits_count
 * @property \App\Models\Business[]|\Illuminate\Database\Eloquent\Collection                                           $business
 * @property null|int                                                                                                  $business_count
 * @property null|\App\Models\Team                                                                                     $currentTeam
 * @property string                                                                                                    $full_name
 * @property \Illuminate\Database\Eloquent\Collection|\Mpociot\Teamwork\TeamInvite[]                                   $invites
 * @property null|int                                                                                                  $invites_count
 * @property Media[]|\Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection                          $media
 * @property null|int                                                                                                  $media_count
 * @property \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection $notifications
 * @property null|int                                                                                                  $notifications_count
 * @property \App\Models\Orders[]|\Illuminate\Database\Eloquent\Collection                                             $orders
 * @property null|int                                                                                                  $orders_count
 * @property \App\Models\Permission[]|\Illuminate\Database\Eloquent\Collection                                         $permissions
 * @property null|int                                                                                                  $permissions_count
 * @property \App\Models\Role[]|\Illuminate\Database\Eloquent\Collection                                               $roles
 * @property null|int                                                                                                  $roles_count
 * @property \App\Models\Team[]|\Illuminate\Database\Eloquent\Collection                                               $teams
 * @property null|int                                                                                                  $teams_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail, HasMedia //, Auditable,
{
    use InteractsWithMedia;
    use Notifiable;
    use HasRoles;
    use IncludeTrashedTrait;
    use UserHasTeams;
    //use \OwenIt\Auditing\Auditable;
    use HasRoles {
        hasPermissionTo as hasPermissionToOriginal;
    }
    use SoftDeletes;

    public $guard_name = 'web';

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved'          => 'boolean',
        'kyc_upload'        => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermissionTo($permission, $guardName = '*'): bool
    {
        return $this->hasPermissionToOriginal($permission, $guardName);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * A merchant user has many businesses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function business()
    {
        return $this->hasMany(Business::class, 'owner_id');
    }

    /**
     * A merchant user has many businesses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manager()
    {
        return $this->hasMany(Business::class, 'manager_id');
    }

    public function orders()
    {
        return $this->hasMany(Orders::class, 'user_id');
    }

    public function shippingAddress()
    {
        return $this->hasMany('App\Models\ShippingAddress');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollectionNames::PROFILE)
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumbnail')
                    ->width(150)
                    ->height(150);
            });
    }

    protected function getDefaultGuardName(): string
    {
        return '*';
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
