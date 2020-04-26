<?php

namespace Modules\Plugins\Payment\Models;

use Modules\Base\Models\BaseModel;
use Modules\Base\Traits\EnumCastable;
use Modules\Plugins\Payment\Enums\PaymentMethodEnum;
use Modules\Plugins\Vendor\Models\Package;
use Modules\Plugins\Vendor\Models\Vendor;
use Html;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'amount',
        'currency',
        'user_id',
        'charge_id',
        'payment_channel',
        'description',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'payment_channel' => PaymentMethodEnum::class,
    ];

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $time = Html::tag('span', $this->created_at->diffForHumans(), ['class' => 'small italic']);

        return 'You have created a payment #' . $this->charge_id . ' via ' . $this->payment_channel->label() . ' ' . $time .
            ': ' . number_format($this->amount, 2, '.', ',') . $this->currency;
    }



}
