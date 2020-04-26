<?php

namespace Modules\Plugins\Contact\Http\Requests;

use Modules\Support\Http\Requests\Request;

class ContactRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
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
            'name.required'                 => trans('modules.plugins.contact::contact.name.required'),
            'email.required'                => trans('modules.plugins.contact::contact.email.required'),
            'email.email'                   => trans('modules.plugins.contact::contact.email.email'),
            'content.required'              => trans('modules.plugins.contact::contact.content.required'),
            'g-recaptcha-response.required' => trans('modules.plugins.contact::contact.g-recaptcha-response.required'),
            'g-recaptcha-response.captcha'  => trans('modules.plugins.contact::contact.g-recaptcha-response.captcha'),
        ];
    }
}
