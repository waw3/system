<?php

namespace Modules\Plugins\Backup\Http\Controllers;

use Assets;
use Modules\Plugins\Backup\Supports\Backup;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Supports\Helper;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BackupController extends BaseController
{

    /**
     * @var Backup
     */
    protected $backup;

    /**
     * BackupController constructor.
     * @param Backup $backup
     *
     */
    public function __construct(Backup $backup)
    {
        $this->backup = $backup;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getIndex()
    {
        page_title()->setTitle(trans('modules.plugins.backup::backup.menu_name'));

        Assets::addScriptsDirectly(['vendor/core/plugins/backup/js/backup.js'])
            ->addStylesDirectly(['vendor/core/plugins/backup/css/backup.css']);

        $backups = $this->backup->getBackupList();

        return view('modules.plugins.backup::index', compact('backups'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     *
     * @throws \Throwable
     */
    public function store(Request $request, BaseHttpResponse $response)
    {
        try {
            $data = $this->backup->createBackupFolder($request);
            $this->backup->backupDb();
            $this->backup->backupFolder(public_path('storage'));
            do_action(BACKUP_ACTION_AFTER_BACKUP, BACKUP_MODULE_SCREEN_NAME, $request);

            return $response
                ->setData(view('modules.plugins.backup::partials.backup-item', $data)->render())
                ->setMessage(trans('modules.plugins.backup::backup.create_backup_success'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * @param string $folder
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     *
     */
    public function destroy($folder, BaseHttpResponse $response)
    {
        try {
            $this->backup->deleteFolderBackup(storage_path('app/backup/') . $folder);
            return $response->setMessage(trans('modules.plugins.backup::backup.delete_backup_success'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * @param string $folder
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     *
     */
    public function getRestore($folder, Request $request, BaseHttpResponse $response)
    {
        try {
            $path = storage_path('app/backup/') . $folder;
            foreach (scan_folder($path) as $file) {
                if (Str::contains(basename($file), 'database')) {
                    $this->backup->restoreDb($path . DIRECTORY_SEPARATOR . $file, $path);
                }

                if (Str::contains(basename($file), 'storage')) {
                    $pathTo = public_path('storage');
                    foreach (File::glob(rtrim($pathTo, '/') . '/*') as $item) {
                        if (File::isDirectory($item)) {
                            File::deleteDirectory($item);
                        } elseif (!in_array(File::basename($item), ['.htaccess', '.gitignore'])) {
                            File::delete($item);
                        }
                    }

                    $this->backup->restore($path . DIRECTORY_SEPARATOR . $file, $pathTo);
                }
            }

            Helper::executeCommand('cache:clear');

            try {
                Helper::executeCommand('key:generate');
            } catch (Exception $exception) {
                info($exception->getMessage());
            }

            do_action(BACKUP_ACTION_AFTER_RESTORE, BACKUP_MODULE_SCREEN_NAME, $request);

            return $response->setMessage(trans('modules.plugins.backup::backup.restore_backup_success'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * @param string $folder
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|boolean
     *
     */
    public function getDownloadDatabase($folder)
    {
        $path = storage_path('app/backup/') . $folder;
        foreach (scan_folder($path) as $file) {
            if (Str::contains(basename($file), 'database')) {
                return response()->download($path . DIRECTORY_SEPARATOR . $file);
            }
        }

        return true;
    }

    /**
     * @param string $folder
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|boolean
     *
     */
    public function getDownloadUploadFolder($folder)
    {
        $path = storage_path('app/backup/') . $folder;
        foreach (scan_folder($path) as $file) {
            if (Str::contains(basename($file), 'storage')) {
                return response()->download($path . DIRECTORY_SEPARATOR . $file);
            }
        }

        return true;
    }
}
