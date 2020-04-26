<?php

namespace Modules\Plugins\Payment\Http\Requests;

use Modules\Support\Http\Requests\Request;

class PaymentMethodRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     */
    public function rules()
    {
        return [
            'type' => 'required|max:120',
        ];
    }
}
