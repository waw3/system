<?php

namespace Modules\Plugins\Comments\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Models\BaseModel;

class Comments extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'dob',
        'content',
        'image'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
