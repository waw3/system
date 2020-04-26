<?php

namespace Modules\Media\Http\Requests;

use Modules\Support\Http\Requests\Request;

class MediaFileRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $files = $this->file('file', []);

        if (!empty($files)) {
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach (array_keys($files) as $key) {
                $rules['file.' . $key] = 'required|mimes:' . mconfig('media.config.allowed_mime_types');
            }
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $files = $this->file('file', []);
        $attributes = [];
        if (!empty($files)) {
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach (array_keys($files) as $key) {
                $attributes['file.' . $key] = 'file';
            }
        }

        return $attributes;
    }
}
