<?php

namespace Modules\Plugins\CustomField\Listeners;

use Modules\Base\Events\DeletedContentEvent;
use CustomField;
use Exception;

class DeletedContentListener
{

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            CustomField::deleteCustomFields($event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
