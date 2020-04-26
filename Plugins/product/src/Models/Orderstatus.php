<?php

namespace Modules\Plugins\Product\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Models\BaseModel;

class Orderstatus extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orderstatuses';

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

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Orderstatus::class, 'product_orderstatuses', 'orderstatuses_id', 'cart_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Orderstatus::class, 'parent_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Orderstatus::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Orderstatus $orderstatus) {
           
          /*  $cart->orderstatus()->detach();
            */
           
        });
    }
   

}
