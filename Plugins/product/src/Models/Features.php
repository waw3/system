<?php

namespace Modules\Plugins\Product\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Slug\Traits\SlugTrait;
use Modules\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Plugins\Product\Models\Features;

class Features extends BaseModel
{
    use EnumCastable;
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'features';


    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];


   /* public function products()
    {
        return $this->belongsToMany(Product::class, 'product_features')->with('slugable');
    }*/

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_features', 'features_id', 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Features::class, 'parent_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Features::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Features $features) {
            $features->products()->detach();
        });
    }
}
