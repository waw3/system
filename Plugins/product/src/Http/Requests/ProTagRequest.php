<?php

namespace Modules\Plugins\Product\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProTagRequest extends Request
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
            'name'        => 'required|max:120',
            'slug'        => 'required|max:120',
            'description' => 'max:400',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
