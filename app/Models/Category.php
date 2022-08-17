<?php

namespace App\Models;

use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\Category.
 *
 * @property int                                                 $id
 * @property null|int                                            $business_type_id
 * @property null|int                                            $parent_id
 * @property string                                              $name
 * @property string                                              $slug
 * @property null|\Illuminate\Support\Carbon                     $created_at
 * @property null|\Illuminate\Support\Carbon                     $updated_at
 * @property null|\App\Models\BusinessType                       $businessType
 * @property Category[]|\Illuminate\Database\Eloquent\Collection $categories
 * @property null|int                                            $categories_count
 * @property Category[]|\Illuminate\Database\Eloquent\Collection $childrenCategories
 * @property null|int                                            $children_categories_count
 * @property null|Category                                       $parentCategory
 * @property null|Category                                       $parents
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Category findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereBusinessTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use Sluggable;

    // use QueryCacheable;

    // protected $cacheFor = 604800;

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * A category belongs to a business type.
     */
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function parents()
    {
        return $this->belongsTo(Category::class, 'parent_id')->with('parentCategory');
    }

    public function products()
    {
        return $this->hasMany(FashionProduct::class, 'category_id');
    }

    /**
     * {@inheritdoc}
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'unique' => false,
            ],
        ];
    }

    /**
     * Customize the slug generated for this model.
     *
     * @param Slugify $engine
     * @param         $attribute
     *
     * @return Slugify
     */
    public function customizeSlugEngine(Slugify $engine, $attribute)
    {
        $engine->addRule('\'', '');

        return $engine;
    }
}
