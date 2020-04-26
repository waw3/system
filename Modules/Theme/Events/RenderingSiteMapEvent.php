<?php

namespace Modules\Theme\Events;

use Modules\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RenderingSiteMapEvent extends Event
{
    use SerializesModels;
}
