<?php

namespace Modules\Plugins\RealEstate\Models;

use Modules\Base\Models\BaseModel;

class Currency extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'symbol',
        'is_prefix_symbol',
        'order',
        'decimals',
        'is_default',
        'exchange_rate',
    ];
}
