<?php

namespace App\Models;

use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\BusinessType.
 *
 * @property int                                                             $id
 * @property string                                                          $name
 * @property null|string                                                     $description
 * @property string                                                          $slug
 * @property null|\Illuminate\Support\Carbon                                 $created_at
 * @property null|\Illuminate\Support\Carbon                                 $updated_at
 * @property \App\Models\Business[]|\Illuminate\Database\Eloquent\Collection $businesses
 * @property null|int                                                        $businesses_count
 * @property \App\Models\Category[]|\Illuminate\Database\Eloquent\Collection $categories
 * @property null|int                                                        $categories_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessType extends Model
{
    use Sluggable;
    use QueryCacheable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'slug',
    ];

    protected $cacheFor = 640800;
    /**
     * A business type has many businesses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businesses()
    {
        return $this->hasMany(Business::class, 'business_type_id');
    }

    /**
     * A business type has many categories.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
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
}
