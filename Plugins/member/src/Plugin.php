<?php

namespace Modules\Plugins\Member;

use Modules\PluginManagement\Abstracts\PluginOperationAbstract;
use Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_password_resets');
    }
}
