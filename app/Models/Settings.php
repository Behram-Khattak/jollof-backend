<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Settings.
 *
 * @property int                                                                      $id
 * @property int                                                                      $setting_type_id
 * @property string                                                                   $name
 * @property string                                                                   $slug
 * @property null|string                                                              $value
 * @property null|\Illuminate\Support\Carbon                                          $created_at
 * @property null|\Illuminate\Support\Carbon                                          $updated_at
 * @property null|\Illuminate\Support\Carbon                                          $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property null|int                                                                 $audits_count
 * @property \App\Models\SettingType                                                  $type
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Settings findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newQuery()
 * @method static \Illuminate\Database\Query\Builder|Settings onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereSettingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|Settings withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Settings withoutTrashed()
 * @mixin \Eloquent
 */
class Settings extends Model implements Auditable
{
    use Sluggable;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Set the settings name.
     *
     * @param string $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * A Setting belongs to a SettingType.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(SettingType::class, 'setting_type_id');
    }
}
