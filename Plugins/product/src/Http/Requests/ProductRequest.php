<?php

namespace Modules\Plugins\Product\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:255',
            'description' => 'max:400',
            'pricesell' => 'max:255|required',
            'pricecost' => 'max:255|required',
            'procategories'  => 'required',
            'slug'        => 'required|max:255',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
