<?php

namespace Modules\Plugins\Contact\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Contact\Repositories\Interfaces\ContactInterface;

class ContactCacheDecorator extends CacheAbstractDecorator implements ContactInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnread($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function countUnread()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
