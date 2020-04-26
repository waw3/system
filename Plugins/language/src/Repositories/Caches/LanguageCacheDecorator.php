<?php

namespace Modules\Plugins\Language\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Language\Repositories\Interfaces\LanguageInterface;

class LanguageCacheDecorator extends CacheAbstractDecorator implements LanguageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getActiveLanguage($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLanguage($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
