<?php

namespace Modules\Plugins\RealEstate\Http\Requests;

use Modules\Support\Http\Requests\Request;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class SendConsultRequest extends Request
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
        if (setting('enable_captcha') && is_plugin_active('captcha')) {
            return [
                'name'                 => 'required',
                'email'                => 'required|email',
                'content'              => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ];
        }
        return [
            'name'    => 'required',
            'email'   => 'required|email',
            'content' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'                 => trans('modules.plugins.real-estate::consult.name.required'),
            'email.required'                => trans('modules.plugins.real-estate::consult.email.required'),
            'email.email'                   => trans('modules.plugins.real-estate::consult.email.email'),
            'content.required'              => trans('modules.plugins.real-estate::consult.content.required'),
            'g-recaptcha-response.required' => trans('modules.plugins.real-estate::consult.g-recaptcha-response.required'),
            'g-recaptcha-response.captcha'  => trans('modules.plugins.real-estate::consult.g-recaptcha-response.captcha'),
        ];
    }
}
