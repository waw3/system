<?php

namespace Modules\Plugins\RealEstate\Http\Requests;

use Modules\Plugins\RealEstate\Enums\ModerationStatusEnum;
use Modules\Plugins\RealEstate\Enums\PropertyStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PropertyRequest extends Request
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
            'moderation_status' => Rule::in(ModerationStatusEnum::values()),
        ];
    }
}
