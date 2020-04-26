<?php

namespace Modules\SeoHelper\Contracts\Entities;

use Modules\SeoHelper\Contracts\RenderableContract;

interface WebmastersContract extends RenderableContract
{
    /**
     * Make Webmaster instance.
     *
     * @param  array $webmasters
     *
     * @return self
     */
    public static function make(array $webmasters = []);

    /**
     * Add a webmaster to collection.
     *
     * @param  string $webmaster
     * @param  string $content
     *
     * @return self
     */
    public function add($webmaster, $content);

    /**
     * Reset the webmaster collection.
     *
     * @return self
     */
    public function reset();
}
