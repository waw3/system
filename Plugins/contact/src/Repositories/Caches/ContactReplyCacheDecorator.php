<?php

namespace Modules\Plugins\Contact\Repositories\Caches;

use Modules\Plugins\Contact\Repositories\Interfaces\ContactReplyInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class ContactReplyCacheDecorator extends CacheAbstractDecorator implements ContactReplyInterface
{
}
