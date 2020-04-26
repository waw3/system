<?php

namespace Modules\Plugins\Comments;

use Schema;
use Modules\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('comments');
    }
}
