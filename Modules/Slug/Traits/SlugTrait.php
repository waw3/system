<?php

namespace Modules\Slug\Traits;

use Modules\Slug\Models\Slug;
use Eloquent;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * @mixin Eloquent
 */
trait SlugTrait
{
    /**
     * @return string
     */
    public function slugable()
    {
        return $this->morphOne(Slug::class, 'reference');
    }

    /**
     * @return string
     */
    public function getSlugAttribute()
    {
        return $this->slugable ? $this->slugable->key : '';
    }

    /**
     * @param $value
     * @return int
     */
    public function getSlugIdAttribute()
    {
        return $this->slugable ? $this->slugable->id : '';
    }

    /**
     * @return UrlGenerator|string
     */
    public function getUrlAttribute()
    {
        $prefix = $this->slugable ? $this->slugable->prefix : null;
        $prefix = apply_filters('slug-prefix-filter', $prefix);

        return url($prefix ? $prefix . '/' . $this->slug : $this->slug);
    }
}