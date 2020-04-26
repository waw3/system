<?php

namespace Modules\Plugins\Location\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'abbreviation',
        'country_id',
        'order',
        'is_default',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }
}
