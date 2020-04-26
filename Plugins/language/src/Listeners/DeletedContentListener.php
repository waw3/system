<?php

namespace Modules\Plugins\Language\Listeners;

use Modules\Base\Events\DeletedContentEvent;
use Exception;
use Language;

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
            Language::deleteLanguage($event->screen, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
