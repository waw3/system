<?php

namespace Modules\Plugins\Career\Http\Requests;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CareerRequest extends Request
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
            'location'    => 'required',
            'salary'      => 'required',
            'description' => 'required',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
