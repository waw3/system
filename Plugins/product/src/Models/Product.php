<?php

namespace Modules\Plugins\Product\Models;

use Modules\ACL\Models\User;
use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Revision\Traits\Revisionable;
use Modules\Slug\Traits\SlugTrait;
use Modules\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Plugins\Product\Models\Orderstatus;

/**
 * Product class.
 *
 * @extends BaseModel
 */
class Product extends BaseModel
{
    use Revisionable;
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * @var mixed
     */
    protected $revisionEnabled = true;

    /**
     * @var mixed
     */
    protected $revisionCleanup = true;

    /**
     * @var int
     */
    protected $historyLimit = 20;

    /**
     * @var array
     */
    protected $dontKeepRevisionOf = [
        'content',
        'views',
    ];

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'content',
        'image',
        'images',
        'imagedl',
        'color',
        'colors',
        'sizes',
        'pricecost',
        'pricesell',
        'pricesale',
        'pricetime',
        'amound',
        'price_sale_start',
        'price_sale_end',
        'is_featured',
        'format_type',
        'status',
        'author_id',
        'author_type',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * user function.
     *
     * @access public
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * getImagesAttribute function.
     *
     * @access public
     * @param mixed $value
     * @return void
     */
    public function getImagesAttribute($value)
    {
        try {
            if ($value === '[null]') {
                return [];
            }

            return json_decode($value) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * getImageAttribute function.
     *
     * @access public
     * @return string|null
     */
    public function getImageAttribute(): ?string
    {
        return Arr::first($this->images) ?? null;
    }

    /**
     * getColorsAttribute function.
     *
     * @access public
     * @param mixed $value
     * @return void
     */
    public function getColorsAttribute($value)
    {
        try {
            if ($value === '[null]') {
                return [];
            }

            return json_decode($value) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * getColorAttribute function.
     *
     * @access public
     * @return string|null
     */
    public function getColorAttribute(): ?string
    {
        return Arr::first($this->colors) ?? null;
    }

    /**
     * getSizesAttribute function.
     *
     * @access public
     * @param mixed $value
     * @return void
     */
    public function getSizesAttribute($value)
    {
        try {
            if ($value === '[null]') {
                return [];
            }

            return json_decode($value) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * getSizeAttribute function.
     *
     * @access public
     * @return string|null
     */
    public function getSizeAttribute(): ?string
    {
        return Arr::first($this->sizes) ?? null;
    }

    /**
     * protags function.
     *
     * @access public
     * @return BelongsToMany
     */
    public function protags()
    {
        return $this->belongsToMany(ProTag::class, 'product_tags');
    }

    /**
     * procategories function.
     *
     * @access public
     * @return BelongsToMany
     */
    public function procategories()
    {
        return $this->belongsToMany(ProCategory::class, 'product_categories');
    }

    /**
     * features function.
     *
     * @access public
     * @return BelongsToMany
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Features::class, 'product_features', 'product_id', 'features_id');
    }

    /**
     * author function.
     *
     * @access public
     * @return MorphTo
     */
    public function author()
    {
        return $this->morphTo();
    }

    /**
     * boot function.
     *
     * @access protected
     * @static
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Product $product) {
            $product->procategories()->detach();
            //$product->features()->detach();
            $product->protags()->detach();
        });
    }
}
