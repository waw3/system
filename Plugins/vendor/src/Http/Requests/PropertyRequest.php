<?php

namespace Modules\Plugins\Vendor\Http\Requests;

use Modules\Plugins\RealEstate\Enums\PropertyStatusEnum;
use Modules\Plugins\RealEstate\Http\Requests\PropertyRequest as BaseRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'max:350',
            'content' => 'required',
            'number_bedroom' => 'numeric|min:0|max:10000|nullable',
            'number_bathroom' => 'numeric|min:0|max:10000|nullable',
            'number_floor' => 'numeric|min:0|max:10000|nullable',
            'price' => 'numeric|min:0|nullable',
            'status' => Rule::in(PropertyStatusEnum::values()),
        ];
    }
}
