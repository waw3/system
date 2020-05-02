<?php

namespace Modules\Member\Http\Requests;

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
            'current_password' => 'required|min:6|max:60',
            'password'         => 'required|min:6|max:60|confirmed',
        ];
    }
}
