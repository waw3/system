<?php

namespace Modules\Plugins\Member\Http\Requests;

class PostRequest extends \Modules\Plugins\Blog\Http\Requests\PostRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return parent::rules();
    }
}
