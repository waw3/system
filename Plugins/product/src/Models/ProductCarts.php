<?php

namespace Modules\Plugins\Product\Models;

use Modules\Revision\Traits\Revisionable;
use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\ACL\Models\User;

class ProductCarts extends BaseModel
{
    use Revisionable;
    use EnumCastable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_carts';

    /**
     * @var array
     */
    protected $fillable = [
        'carts_id',
        'carts_size',
        'carts_amound',
        'product_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

}
