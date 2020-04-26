<?php

namespace Modules\Media\Http\Requests;

use Modules\Support\Http\Requests\Request;

class MediaFolderRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[\pL\s\ \_\-0-9]+$/u',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.regex' => trans('modules.media::media.name_invalid'),
        ];
    }
}
