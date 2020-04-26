<?php

namespace Modules\Plugins\Gallery\Listeners;

use Modules\Base\Events\DeletedContentEvent;
use Exception;
use Gallery;

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
            Gallery::deleteGallery($event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
