<?php

namespace Modules\Member\Http\Resources;

use Modules\Member\Models\MemberActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MemberActivityLog
 */
class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'ip_address'  => $this->ip_address,
            'description' => $this->getDescription(),
        ];
    }
}
