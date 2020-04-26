<?php

namespace Modules\Slug\Services;

use Illuminate\Support\Arr;

class SlugHelper
{
    /**
     * @param string | array $model
     * @return $this
     */
    public function registerModule($model): self
    {
        if (!is_array($model)) {
            $model = [$model];
        }
        config([
            'modules.slug.config.supported' => array_merge(config('modules.slug.config.supported', []), $model),
        ]);

        return $this;
    }

    /**
     * @param string $model
     * @param string|null $prefix
     * @return $this
     */
    public function setPrefix(string $model, ?string $prefix): self
    {
        $prefixes = config('modules.slug.config.prefixes', []);
        $prefixes[$model] = $prefix;

        config(['modules.slug.config.prefixes' => $prefixes]);

        return $this;
    }

    /**
     * @param string $model
     * @return string|null
     */
    public function getPrefix(string $model): ?string
    {
        return Arr::get(config('modules.slug.config.prefixes', []), $model, '');
    }

    /**
     * @return array
     */
    public function supportedModels()
    {
        return config('modules.slug.config.supported', []);
    }

    /**
     * @return array
     */
    public function isSupportedModel(string $model): bool
    {
        return in_array($model, $this->supportedModels());
    }

    /**
     * @param $model
     * @return $this
     */
    public function disablePreview($model)
    {
        if (!is_array($model)) {
            $model = [$model];
        }
        config([
            'modules.slug.config.disable_preview' => array_merge(config('modules.slug.config.disable_preview', []), $model),
        ]);

        return $this;
    }

    public function canPreview(string $model)
    {
        return !in_array($model, config('modules.slug.config.disable_preview', []));
    }
}
