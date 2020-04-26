<?php

namespace Modules\Plugins\Product\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Models\BaseModel;

class Shipping extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shippings';

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
        return $this->belongsToMany(Shipping::class, 'product_shippings', 'shippings_id', 'cart_id');
    }


    public function parent()
    {
        return $this->belongsTo(Shipping::class, 'parent_id')->withDefault();
    }

    public function children()
    {
        return $this->hasMany(Shipping::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Shipping $shipping) {

          /*  $cart->orderstatus()->detach();
            */

        });
    }
}
