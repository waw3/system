<?php

namespace Modules\SeoHelper\Entities;

use Modules\SeoHelper\Bases\MetaCollection as BaseMetaCollection;
use Modules\SeoHelper\Helpers\Classes\Meta;

class MetaCollection extends BaseMetaCollection
{
    /**
     * Ignored tags, they have dedicated class.
     *
     * @var array
     */
    protected $ignored = [
        'description',
    ];

    /**
     * Add a meta to collection.
     *
     * @param  string $name
     * @param  string $content
     *
     * @return \Modules\SeoHelper\Entities\MetaCollection
     */
    public function add($item)
    {
        $meta = Meta::make($item['name'], $item['content']);

        if ($meta->isValid() && !$this->isIgnored($item['name'])) {
            $this->put($meta->key(), $meta);
        }

        return $this;
    }
}
