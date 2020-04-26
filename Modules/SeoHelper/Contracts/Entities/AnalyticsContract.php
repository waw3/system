<?php

namespace Modules\SeoHelper\Contracts\Entities;

use Modules\SeoHelper\Contracts\RenderableContract;

interface AnalyticsContract extends RenderableContract
{
    /**
     * Set Google Analytics code.
     *
     * @param  string $code
     *
     * @return self
     */
    public function setGoogle($code);
}
