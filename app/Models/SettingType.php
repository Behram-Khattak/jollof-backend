<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SettingType.
 *
 * @property int                                                             $id
 * @property string                                                          $name
 * @property string                                                          $slug
 * @property null|\Illuminate\Support\Carbon                                 $created_at
 * @property null|\Illuminate\Support\Carbon                                 $updated_at
 * @property \App\Models\Settings[]|\Illuminate\Database\Eloquent\Collection $settings
 * @property null|int                                                        $settings_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SettingType extends Model
{
    use Sluggable;

    /**
     * The possible names of SettingType that exist.
     */
    const NAMES = [
        'Email Content',
    ];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * {@inheritdoc}
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * A SettingType has many Settings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany(Settings::class, 'setting_type_id');
    }
}
