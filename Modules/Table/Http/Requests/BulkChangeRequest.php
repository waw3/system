<?php

namespace Modules\Table\Http\Requests;

use Modules\Support\Http\Requests\Request;

class BulkChangeRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'class' => 'required',
        ];
    }
}
