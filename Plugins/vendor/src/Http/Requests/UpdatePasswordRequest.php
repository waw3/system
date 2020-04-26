<?php

namespace Modules\Plugins\Vendor\Http\Requests;

use Modules\Support\Http\Requests\Request;

class UpdatePasswordRequest extends Request
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
            'password' => 'required|min:6|max:60|confirmed',
        ];
    }
}
