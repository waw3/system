<?php

namespace Modules\Plugins\Career;

use Schema;
use Modules\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('careers');
    }
}
