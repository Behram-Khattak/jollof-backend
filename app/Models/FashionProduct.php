<?php

namespace App\Models;

use App\Enums\MediaCollectionNames;
use App\Traits\IncludeTrashedTrait;
use BinaryCats\Sku\HasSku;
use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\FashionProduct.
 *
 * @property int                                                                                                                           $id
 * @property int                                                                                                                           $business_id
 * @property int                                                                                                                           $category_id
 * @property int                                                                                                                           $material_id
 * @property int                                                                                                                           $color_id
 * @property null|int                                                                                                                      $size_type_id
 * @property null|int                                                                                                                      $size_value_id
 * @property string                                                                                                                        $name
 * @property string                                                                                                                        $slug
 * @property string                                                                                                                        $description
 * @property int                                                                                                                           $quantity
 * @property string                                                                                                                        $price
 * @property null|string                                                                                                                   $sales_price
 * @property null|float                                                                                                                    $weight
 * @property string                                                                                                                        $sku
 * @property bool                                                                                                                          $is_available
 * @property null|\Illuminate\Support\Carbon                                                                                               $sales_start
 * @property null|\Illuminate\Support\Carbon                                                                                               $sales_end
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $deleted_at
 * @property \App\Models\Category                                                                                                          $category
 * @property \App\Models\FashionProductColor                                                                                               $color
 * @property mixed                                                                                                                         $featured_image
 * @property mixed                                                                                                                         $product_images
 * @property string                                                                                                                        $running_promo
 * @property \App\Models\FashionProductMaterial                                                                                            $material
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 * @property \App\Models\Business                                                                                                          $owner
 * @property null|\App\Models\FashionProductSizeType                                                                                       $sizeType
 * @property null|\App\Models\FashionProductSizeValue                                                                                      $sizeValue
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct newQuery()
 * @method static \Illuminate\Database\Query\Builder|FashionProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereSalesEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereSalesPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereSalesStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereSizeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereSizeValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FashionProduct whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|FashionProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FashionProduct withoutTrashed()
 * @mixin \Eloquent
 */
class FashionProduct extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Sluggable;
    use HasSku;
    use SoftDeletes;
    use IncludeTrashedTrait;

    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'sales_start', 'sales_end',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['running_promo', 'featured_image', 'product_images'];

    /**
     * A fashion product belongs to a business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function material()
    {
        return $this->belongsTo(FashionProductMaterial::class, 'material_id');
    }

    public function color()
    {
        return $this->belongsTo(FashionProductColor::class, 'color_id');
    }

    public function sizeType()
    {
        return $this->belongsTo(FashionProductSizeType::class, 'size_type_id');
    }

    public function sizeValue()
    {
        return $this->belongsTo(FashionProductSizeValue::class, 'size_value_id');
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getRunningPromoAttribute()
    {
        return now()->between(now()->make($this->sales_start), now()->make($this->sales_end)) ? true : false;
    }

    public function getFeaturedImageAttribute()
    {
        return $this->getFirstMediaUrl(MediaCollectionNames::FEATURED_IMAGE);
    }

    public function getProductImagesAttribute()
    {
        $images = [];
        $collection = $this->getMedia(MediaCollectionNames::PRODUCT_IMAGES);

        foreach ($collection as $item) {
            array_push($images, $item->getUrl());
        }

        return $images;
    }

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollectionNames::FEATURED_IMAGE)->singleFile();

        $this->addMediaCollection(MediaCollectionNames::PRODUCT_IMAGES);
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('big-crop')
            ->height(400);
        $this->addMediaConversion('small-crop')
            ->height(100);
    }
}
