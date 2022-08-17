<?php

namespace App\Models;

use App\Enums\MediaCollectionNames;
use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Business.
 *
 * @property int                                                                                                                           $id
 * @property null|int                                                                                                                      $owner_id
 * @property null|int                                                                                                                      $manager_id
 * @property int                                                                                                                           $business_type_id
 * @property string                                                                                                                        $name
 * @property string                                                                                                                        $slug
 * @property string                                                                                                                        $email
 * @property null|string                                                                                                                   $telephone
 * @property null|string                                                                                                                   $whatsapp
 * @property null|string                                                                                                                   $category
 * @property string                                                                                                                        $status
 * @property bool                                                                                                                          $kyc_upload
 * @property string                                                                                                                        $description
 * @property null|string                                                                                                                   $comment
 * @property null|\Illuminate\Support\Carbon                                                                                               $created_at
 * @property null|\Illuminate\Support\Carbon                                                                                               $updated_at
 * @property null|\App\Models\BusinessBankAccount                                                                                          $bankAccount
 * @property \App\Models\FashionProduct[]|\Illuminate\Database\Eloquent\Collection                                                         $fashionProducts
 * @property null|int                                                                                                                      $fashion_products_count
 * @property mixed                                                                                                                         $banner
 * @property mixed                                                                                                                         $logo
 * @property \App\Models\BusinessLocation[]|\Illuminate\Database\Eloquent\Collection                                                       $locations
 * @property null|int                                                                                                                      $locations_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property null|int                                                                                                                      $media_count
 * @property \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection                     $notifications
 * @property null|int                                                                                                                      $notifications_count
 * @property \App\Models\OrderItems[]|\Illuminate\Database\Eloquent\Collection                                                             $orderItems
 * @property null|int                                                                                                                      $order_items_count
 * @property null|\App\Models\User                                                                                                         $owner
 * @property \App\Models\Restaurant[]|\Illuminate\Database\Eloquent\Collection                                                             $restaurant
 * @property null|int                                                                                                                      $restaurant_count
 * @property \App\Models\Team[]|\Illuminate\Database\Eloquent\Collection                                                                   $teams
 * @property null|int                                                                                                                      $teams_count
 * @property \App\Models\BusinessType                                                                                                      $type
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Business findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Business newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business query()
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereKycUpload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereWhatsapp($value)
 * @mixin \Eloquent
 */
class Business extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Sluggable;
    use Notifiable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approved'   => 'boolean',
        'kyc_upload' => 'boolean',
    ];

    protected $appends = ['logo', 'banner'];

    /**
     * A business has a type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }

    /**
     * A business is owned by a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


    /**
     * A business is managed by a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
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

    public function getLogoAttribute()
    {
        return $this->getFirstMediaUrl(MediaCollectionNames::LOGO);
    }

    public function getBannerAttribute()
    {
        return $this->getFirstMediaUrl(MediaCollectionNames::BANNER);
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->whatsapp;
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

    public function restaurant()
    {
        return $this->hasMany(Restaurant::class, 'business_id');
    }

    /**
     * A business has many locations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(BusinessLocation::class, 'business_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'business_id');
    }

    /**
     * A business has many fashion products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fashionProducts()
    {
        return $this->hasMany(FashionProduct::class, 'business_id');
    }

    /**
     * A business has one bank account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bankAccount()
    {
        return $this->hasOne(BusinessBankAccount::class, 'business_id');
    }

    /**
     * Get all teams for the business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function teams()
    {
        return $this->hasManyThrough(
            Team::class,
            BusinessLocation::class,
            'business_id', // Foreign key on users table...
            'location_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }


    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function payout()
    {
        return $this->hasOne(Payout::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollectionNames::KYC);

        $this->addMediaCollection(MediaCollectionNames::LOGO)->singleFile();

        $this->addMediaCollection(MediaCollectionNames::BANNER)->singleFile();
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::created(function ($business) {
            OnboardingFlow::firstOrCreate(
                ['business_id' => $business->id],
                [
                    'locations' => true,
                    'teams'     => true,
                ]
            );
        });
    }
}
