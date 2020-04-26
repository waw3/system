<?php

namespace Modules\Plugins\RealEstate\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Models\BaseModel;

class Category extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 're_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'order',
        'is_default',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
