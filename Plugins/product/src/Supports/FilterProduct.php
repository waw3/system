<?php

namespace Modules\Plugins\Product\Supports;

use Modules\Base\Enums\BaseStatusEnum;

class FilterProduct
{

    /**
     * @param array $request
     * @return array
     */
    public static function setFilters(array $request): array
    {
        return [
            'page'               => $request['page'] ?? 1,
            'per_page'           => $request['per_page'] ?? 10,
            'search'             => $request['search'] ?? null,
            'author'             => $request['author'] ?? null,
            'author_exclude'     => $request['author_exclude'] ?? null,
            'exclude'            => $request['exclude'] ?? null,
            'include'            => $request['include'] ?? null,
            'after'              => $request['after'] ?? null,
            'before'             => $request['before'] ?? null,
            'order'              => $request['order'] ?? 'desc',
            'order_by'           => $request['order_by'] ?? 'updated_at',
            'status'             => BaseStatusEnum::PUBLISHED,
            'procategories'         => $request['procategories'] ?? null,
            'procategories_exclude' => $request['procategories_exclude'] ?? null,
            'protags'               => $request['protags'] ?? null,
            'protags_exclude'       => $request['protags_exclude'] ?? null,
            'featured'           => $request['featured'] ?? null,
        ];
    }
}
