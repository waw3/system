<?php

namespace Modules\Plugins\Vendor\Models;

use Modules\Base\Traits\EnumCastable;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Models\BaseModel;
use Modules\Plugins\RealEstate\Models\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'usd_price',
        'currency_id',
        'percent_save',
        'number_of_listings',
        'account_limit',
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
    public function currency()
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }

    /**
     * @return BelongsToMany
     */
    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'vendor_packages', 'package_id', 'vendor_id');
    }
}
