<?php

namespace Modules\Plugins\Member\Http\Resources;

use Modules\Plugins\Member\Models\MemberActivityLog;
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
