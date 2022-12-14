<?php

namespace App\Models;

use App\Enums\DefaultRoles;
use App\Traits\IncludeTrashedTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Role.
 *
 * @property int                                                                      $id
 * @property string                                                                   $name
 * @property string                                                                   $type
 * @property string                                                                   $guard_name
 * @property null|string                                                              $description
 * @property null|\Illuminate\Support\Carbon                                          $created_at
 * @property null|\Illuminate\Support\Carbon                                          $updated_at
 * @property null|\Illuminate\Support\Carbon                                          $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property null|int                                                                 $audits_count
 * @property bool                                                                     $can_be_renamed
 * @property string                                                                   $status
 * @property \App\Models\Permission[]|\Illuminate\Database\Eloquent\Collection        $permissions
 * @property null|int                                                                 $permissions_count
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection              $users
 * @property null|int                                                                 $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 * @mixin \Eloquent
 */
class Role extends \Spatie\Permission\Models\Role implements Auditable
{
    use SoftDeletes;
    use IncludeTrashedTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guard_name = '*';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status', 'can_be_renamed'];

    /**
     * Set the role's name.
     *
     * @param string $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = isset($value) ? mb_strtolower($value) : null;
    }

    /**
     * Get the status of the role.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->trashed() ? 'inactive' : 'active';
    }

    /**
     * Check whether name of the role can be changed.
     *
     * @return bool
     */
    public function getCanBeRenamedAttribute()
    {
        return in_array($this->name, DefaultRoles::values()) ? false : true;
    }
}
