<?php

namespace Modules\Plugins\Vendor;

use Modules\PluginManagement\Abstracts\PluginOperationAbstract;
use Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('vendor_password_resets');
        Schema::dropIfExists('packages');
    }
}
