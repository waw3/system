<?php

namespace Modules\Page\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PageRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|max:120',
            'content' => 'required',
            'slug'    => 'required|max:255',
            'status'  => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
