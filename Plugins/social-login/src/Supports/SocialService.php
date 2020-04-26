<?php

namespace Modules\Plugins\SocialLogin\Supports;

class SocialService
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
            'modules.plugins.social-login.general.supported' => array_merge(config('modules.plugins.social-login.general.supported', []), $model),
        ]);

        return $this;
    }

    /**
     * @return array
     */
    public function supportedModules()
    {
        return config('modules.plugins.social-login.general.supported', []);
    }

    /**
     * @return array
     */
    public function isSupportedModule(string $model): bool
    {
        return in_array($model, $this->supportedModules());
    }
}
