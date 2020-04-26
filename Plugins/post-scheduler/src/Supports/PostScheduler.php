<?php

namespace Modules\Plugins\PostScheduler\Supports;

class PostScheduler
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
            'modules.plugins.post-scheduler.general.supported' => array_merge(mconfig('plugins.post-scheduler.general.supported', []), $model),
        ]);

        return $this;
    }

    /**
     * @return array
     */
    public function supportedModules()
    {
        return mconfig('plugins.post-scheduler.general.supported', []);
    }

    /**
     * @return array
     */
    public function isSupportedModule(string $model): bool
    {
        return in_array($model, $this->supportedModules());
    }
}
