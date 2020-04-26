<?php

namespace Modules\Plugins\Vendor\Listeners;

use Modules\Base\Events\UpdatedContentEvent;
use Modules\Plugins\Vendor\Models\Vendor;
use Modules\Plugins\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Exception;

class UpdatedContentListener
{
    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            if ($event->data->id &&
                $event->data->author_type === Vendor::class &&
                auth()->guard('vendor')->check() &&
                $event->data->author_id == auth()->guard('vendor')->user()->getKey()
            ) {
                app(VendorActivityLogInterface::class)->createOrUpdate([
                    'action'         => 'your_property_updated_by_admin',
                    'reference_name' => $event->data->name,
                    'reference_url'  => route('public.vendor.properties.edit', $event->data->id),
                ]);
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
