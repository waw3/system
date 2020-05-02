<?php

namespace Modules\Member\Http\Requests;

class PostRequest extends \Modules\Blog\Http\Requests\PostRequest
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
