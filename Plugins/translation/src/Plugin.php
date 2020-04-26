<?php

namespace Modules\Plugins\Translation;

use Modules\PluginManagement\Abstracts\PluginOperationAbstract;
use Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('translations');
    }
}
