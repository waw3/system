<?php

namespace Modules\Plugins\Product\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Slug\Traits\SlugTrait;
use Modules\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProCategory extends BaseModel
{
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'procategories';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

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
        'parent_id',
        'icon',
        'is_featured',
        'order',
        'is_default',
        'status',
        'author_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories')->with('slugable');
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(ProCategory::class, 'parent_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(ProCategory::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (ProCategory $procategory) {
            $procategory->products()->detach();
        });
    }
}
