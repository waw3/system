<?php

namespace Modules\Plugins\Backup;

use Modules\PluginManagement\Abstracts\PluginOperationAbstract;
use File;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        $backup_path = storage_path('app/backup');
        if (File::isDirectory($backup_path)) {
            File::deleteDirectory($backup_path);
        }
    }
}
