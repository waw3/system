<?php

namespace Modules\Menu\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class MenuRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required|min:3|max:120',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
