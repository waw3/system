<?php

namespace Modules\Plugins\RealEstate\Http\Requests;

use Modules\Support\Http\Requests\Request;

class FeatureRequest extends Request
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
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('modules.plugins.real-estate::feature.messages.request.name_required'),
        ];
    }
}
