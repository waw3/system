<?php

namespace Modules\Plugins\Contact;

use Modules\PluginManagement\Abstracts\PluginOperationAbstract;
use Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('contacts');
    }
}
