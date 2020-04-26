<?php

namespace Modules\Plugins\Payment\Enums;

use Modules\Base\Supports\Enum;

/**
 * @method static PaymentMethodEnum PAYPAL()
 * @method static PaymentMethodEnum STRIPE()
 * @method static PaymentMethodEnum DIRECT()
 */
class PaymentMethodEnum extends Enum
{
    public const PAYPAL = 'paypal';
    public const STRIPE = 'stripe';
    public const DIRECT = 'direct';

    /**
     * @var string
     */
    public static $langPath = 'modules.plugins.payment::payment.methods';
}
