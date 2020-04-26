<?php

namespace Modules\Plugins\Location\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CountryRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'nationality' => 'required',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
