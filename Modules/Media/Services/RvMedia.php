<?php

namespace Modules\Media\Services;

use Modules\Media\Http\Resources\FileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Media\Repositories\Interfaces\MediaFileInterface;
use Modules\Media\Repositories\Interfaces\MediaFolderInterface;
use Modules\Media\Services\UploadsManager;
use Modules\Media\Services\ThumbnailService;
use Exception;
use File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Image;
use Storage;
use Throwable;

class RvMedia
{

    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * @var UploadsManager
     */
    protected $uploadManager;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * @var MediaFolderInterface
     */
    protected $folderRepository;

    /**
     * @var ThumbnailService
     */
    protected $thumbnailService;

    /**
     * @param MediaFileInterface $fileRepository
     * @param MediaFolderInterface $folderRepository
     * @param UploadsManager $uploadManager
     * @param ThumbnailService $thumbnailService
     */
    public function __construct(
        MediaFileInterface $fileRepository,
        MediaFolderInterface $folderRepository,
        UploadsManager $uploadManager,
        ThumbnailService $thumbnailService
    ) {
        $this->fileRepository = $fileRepository;
        $this->folderRepository = $folderRepository;
        $this->uploadManager = $uploadManager;
        $this->thumbnailService = $thumbnailService;

        $this->permissions = mconfig('media.config.permissions', []);
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function renderHeader()
    {
        $urls = $this->getUrls();
        return view('modules.media::header', compact('urls'))->render();
    }

    /**
     * Get all urls
     * @return array
     */
    public function getUrls()
    {
        return [
            'base_url'                 => asset(''),
            'base'                     => route('media.index'),
            'get_media'                => route('media.list'),
            'create_folder'            => route('media.folders.create'),
            'get_quota'                => route('media.quota'),
            'popup'                    => route('media.popup'),
            'download'                 => route('media.download'),
            'upload_file'              => route('media.files.upload'),
            'add_external_service'     => route('media.files.add_external_service'),
            'get_breadcrumbs'          => route('media.breadcrumbs'),
            'global_actions'           => route('media.global_actions'),
            'media_upload_from_editor' => route('media.files.upload.from.editor'),
        ];
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function renderFooter()
    {
        return view('modules.media::footer')->render();
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function renderContent()
    {
        return view('modules.media::content')->render();
    }

    /**
     * @param $data
     * @param null $message
     * @return JsonResponse
     */
    public function responseSuccess($data, $message = null)
    {
        return response()->json([
            'error'   => false,
            'data'    => $data,
            'message' => $message,
        ]);
    }

    /**
     * @param string $message
     * @param array $data
     * @param null $code
     * @param int $status
     * @return JsonResponse
     */
    public function responseError($message, $data = [], $code = null, $status = 200)
    {
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ], $status);
    }

    /**
     * @param $url
     * @return array|mixed
     */
    public function getAllImageSizes($url)
    {
        $images = [];
        foreach (RvMedia::getSizes() as $size) {
            $readableSize = explode('x', $size);
            $images = get_image_url($url, $readableSize);
        }

        return $images;
    }

    /**
     * @return array
     */
    public function getSizes(): array
    {
        return mconfig('media.config.sizes', []);
    }

    /**
     * @param UploadedFile $fileUpload
     * @param int $folderId
     * @param string $path
     * @return JsonResponse|array
     */
    public function handleUpload($fileUpload, $folderId = 0, $path = '')
    {
        if (!$fileUpload) {
            return [
                'error'   => true,
                'message' => trans('modules.media::media.can_not_detect_file_type'),
            ];
        }

        try {
            $file = $this->fileRepository->getModel();

            if ($fileUpload->getSize() / 1024 > (int)mconfig('media.config.max_file_size_upload')) {
                return [
                    'error'   => true,
                    'message' => trans('modules.media::media.file_too_big',
                        ['size' => mconfig('media.config.max_file_size_upload')]),
                ];
            }

            $fileExtension = $fileUpload->getClientOriginalExtension();

            if (!in_array($fileExtension, explode(',', mconfig('media.config.allowed_mime_types')))) {
                return [
                    'error'   => true,
                    'message' => trans('modules.media::media.can_not_detect_file_type'),
                ];
            }

            $file->name = $this->fileRepository->createName(File::name($fileUpload->getClientOriginalName()),
                $folderId);

            $folderPath = $this->folderRepository->getFullPath($folderId, $path);

            $fileName = $this->fileRepository->createSlug($file->name, $fileExtension, Storage::path($folderPath));

            $filePath = $fileName;

            if ($folderPath) {
                $filePath = $folderPath . '/' . $filePath;
            }

            $content = File::get($fileUpload->getRealPath());

            $this->uploadManager->saveFile($filePath, $content);

            $data = $this->uploadManager->fileDetails($filePath);

            if (empty($data['mime_type'])) {
                return [
                    'error'   => true,
                    'message' => trans('modules.media::media.can_not_detect_file_type'),
                ];
            }

            $file->url = $data['url'];
            $file->size = $data['size'];
            $file->mime_type = $data['mime_type'];

            $file->folder_id = $folderId;
            $file->user_id = Auth::check() ? Auth::user()->getKey() : 0;
            $file->options = request()->get('options', []);
            $this->fileRepository->createOrUpdate($file);

            if ($file->canGenerateThumbnails()) {
                foreach (mconfig('media.config.sizes', []) as $size) {
                    $readableSize = explode('x', $size);
                    $this->thumbnailService
                        ->setImage($fileUpload->getRealPath())
                        ->setSize($readableSize[0], $readableSize[1])
                        ->setDestinationPath($folderPath)
                        ->setFileName(File::name($fileName) . '-' . $size . '.' . $fileExtension)
                        ->save();
                }

                if (mconfig('media.config.watermark.source')) {
                    $image = Image::make(public_path($file->url));
                    $image->insert(
                        mconfig('media.config.watermark.source'),
                        mconfig('media.config.watermark.position', 'bottom-right'),
                        mconfig('media.config.watermark.x', 10),
                        mconfig('media.config.watermark.y', 10)
                    );
                    $image->save(public_path($file->url));
                }
            }

            return [
                'error' => false,
                'data'  => new FileResource($file),
            ];
        } catch (Exception $ex) {
            return [
                'error'   => true,
                'message' => $ex->getMessage(),
            ];
        }
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @param string $permission
     */
    public function removePermission($permission)
    {
        Arr::forget($this->permissions, $permission);
    }

    /**
     * @param string $permission
     */
    public function addPermission($permission)
    {
        $this->permissions[] = $permission;
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions);
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasAnyPermission(array $permissions)
    {
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if (in_array($permission, $this->permissions)) {
                $hasPermission = true;
                break;
            }
        }

        return $hasPermission;
    }

    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize and post_max_size
     * @return float|int
     */
    public function getServerConfigMaxUploadFileSize()
    {
        // Start with post_max_size.
        $maxSize = $this->parseSize(ini_get('post_max_size'));

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $uploadMax = $this->parseSize(ini_get('upload_max_filesize'));
        if ($uploadMax > 0 && $uploadMax < $maxSize) {
            $maxSize = $uploadMax;
        }

        return $maxSize;
    }

    /**
     * @param int $size
     * @return float - bytes
     */
    public function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }

        return round($size);
    }

    /**
     * @param string $path
     * @return string
     */
    public function url($path)
    {
        if (Str::contains($path, 'https://')) {
            return $path;
        }

        return Storage::url($path);
    }

    /**
     * @return string
     */
    public function getSize(string $name): ?string
    {
        return mconfig('media.config.sizes.' . $name);
    }

    /**
     * @param string $name
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function addSize(string $name, int $width, int $height)
    {
        config(['modules.media.config.sizes.' . $name => $width . 'x' . $height]);

        return $this;
    }
}
