<?php

namespace Modules\Plugins\Vendor\Http\Requests;

use Modules\Support\Http\Requests\Request;

class VendorChangeAvatarRequest extends Request
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
            'avatar' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
