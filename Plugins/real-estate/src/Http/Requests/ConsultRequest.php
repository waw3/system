<?php

namespace Modules\Plugins\RealEstate\Http\Requests;

use Modules\Plugins\RealEstate\Enums\ConsultStatusEnum;
use Modules\Support\Http\Requests\Request;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Validation\Rule;

class ConsultRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function rules()
    {
        return [
            'status' => Rule::in(ConsultStatusEnum::values()),
        ];
    }
}
