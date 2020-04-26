<?php

namespace Modules\Plugins\Career\Models;

use Modules\Base\Models\BaseModel;
use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Slug\Traits\SlugTrait;

class Career extends BaseModel
{
    use EnumCastable;
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'careers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'salary',
        'description',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
