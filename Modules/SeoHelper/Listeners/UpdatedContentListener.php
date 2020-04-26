<?php

namespace Modules\SeoHelper\Listeners;

use Modules\Base\Events\UpdatedContentEvent;
use Exception;
use SeoHelper;

class UpdatedContentListener
{

    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     *
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            SeoHelper::saveMetaData($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
