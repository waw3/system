<?php

namespace Modules\Block\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BlockRequest extends Request
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
            'name'   => 'required|max:120',
            'alias'  => 'required|max:120',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
