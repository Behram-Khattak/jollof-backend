<?php

namespace App\Models;

use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Mpociot\Teamwork\TeamworkTeam;

/**
 * App\Models\Team.
 *
 * @property int                                                                     $id
 * @property int                                                                     $location_id
 * @property null|int                                                                $owner_id
 * @property string                                                                  $name
 * @property string                                                                  $slug
 * @property null|\Illuminate\Support\Carbon                                         $created_at
 * @property null|\Illuminate\Support\Carbon                                         $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\Mpociot\Teamwork\TeamInvite[] $invites
 * @property null|int                                                                $invites_count
 * @property \App\Models\BusinessLocation                                            $location
 * @property null|\App\Models\User                                                   $owner
 * @property \App\Models\User[]|\Illuminate\Database\Eloquent\Collection             $users
 * @property null|int                                                                $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Team findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Team extends TeamworkTeam
{
    use Sluggable;

    protected $fillable = ['name', 'slug', 'owner_id', 'location_id'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() :array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Customize the slug generated for this model.
     *
     * @param Slugify $engine
     *
     * @return Slugify
     */
    public function customizeSlugEngine(Slugify $engine)
    {
        $engine->addRule('\'', '');

        return $engine;
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }
}
