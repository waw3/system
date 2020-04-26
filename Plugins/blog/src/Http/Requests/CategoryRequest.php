<?php

namespace Modules\Plugins\Blog\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CategoryRequest extends Request
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
            'description' => 'max:400',
            'slug'        => 'required',
            'order'       => 'required|integer|min:0',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
