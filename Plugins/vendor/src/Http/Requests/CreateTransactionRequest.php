<?php

namespace Modules\Plugins\Vendor\Http\Requests;

use Modules\Support\Http\Requests\Request;

class CreateTransactionRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'credits' => 'required|numeric|min:1',
        ];
    }
}
