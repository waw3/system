<?php

namespace Modules\Plugins\Product\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Models\BaseModel;

class Payment extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

 
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'product_payments', 'payments_id', 'cart_id');
    }


    public function parent()
    {
        return $this->belongsTo(Payment::class, 'parent_id')->withDefault();
    }


    public function children()
    {
        return $this->hasMany(Payment::class, 'parent_id');
    }

    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Payment $cart) {
           
          /*  $cart->orderstatus()->detach();
            */
           
        });
    }
}
