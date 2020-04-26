<?php namespace App\Helpers\Classes;

use File, Storage;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class FileHelper
 */
class FileHelper
{

    const GRAPHIC_MIME_TYPES = [
        'image/gif',
        'image/jpeg',
        'image/png'
    ];

    /**
     * displayAttachmentIcon function.
     *
     * @access public
     * @static
     * @param mixed $attachment
     * @return void
     */
    public static function displayAttachmentIcon($attachment)
    {
        if (in_array($attachment->filetype, self::GRAPHIC_MIME_TYPES)) {
            return $attachment->url;
        }
        return '/bap/images/file_icon.png';
    }

    /**
     * Print memory consumption
     */
    public static function memoryInfo()
    {
        if (config('app.debug')) {
            self::echoFormatByest(memory_get_usage());
        }
    }

    /**
     * echoFormatByest function.
     *
     * @access public
     * @static
     * @param mixed $size
     * @param int $precision (default: 2)
     * @return void
     */
    public static function echoFormatByest($size, $precision = 2)
    {
        echo NL;
        echo '*************';
        echo self::formatBytes($size, $precision);
        echo NL;
    }

    /**
     * formatBytes function.
     *
     * @access public
     * @static
     * @param mixed $size
     * @param int $precision (default: 2)
     * @return string
     */
    public static function formatBytes($size, $precision = 2): string
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    /**
     * listFiles function.
     *
     * @access public
     * @static
     * @param mixed $dir
     * @return void
     */
    public static function listFiles($dir)
    {
        $result = array();
        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_file($dir . DS . $value)) {
                    $result[$value] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * @param $image
     * @param $dir
     * @param null $width
     * @param int $height
     * @param $crop
     * @return string
     * @throws \Exception
     */
    public static function upload($image, $dir, $width = null, $height = 800, $crop = false)
    {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $image;
        $folder = $dir . '/';

        if (!$uploadedFile->isValid()) {
            throw new \Exception('File was not uploaded correctly');
        }

        $newName = self::generateNewFileName($uploadedFile->getClientOriginalName());

        $tempPath = public_path('user-uploads/temp/' . $newName);
        /** Check if folder exits or not. If not then create the folder */
        if (!File::exists(public_path('user-uploads/' . $folder))) {
            $result = File::makeDirectory(public_path('user-uploads/' . $folder), 0775, true);
        }

        $newPath = $folder . '/' . $newName;

        /** @var UploadedFile $uploadedFile */
        $uploadedFile->move(public_path('user-uploads/temp'), $newName);

        if (!empty($crop)) {
            // Crop image
            if (isset($crop[0])) {
                // To store the multiple images for the copped ones
                foreach ($crop as $cropped) {
                    $image = Image::make($tempPath);

                    if (isset($cropped['resize']['width']) && isset($cropped['resize']['height'])) {

                        $image->crop(floor($cropped['width']), floor($cropped['height']), floor($cropped['x']), floor($cropped['y']));

                        $fileName = str_replace('.', '_' . $cropped['resize']['width'] . 'x' . $cropped['resize']['height'] . '.', $newName);
                        $tempPathCropped = public_path('user-uploads/temp') . '/' . $fileName;
                        $newPathCropped = $folder . '/' . $fileName;

                        // Resize in Proper format
                        $image->resize($cropped['resize']['width'], $cropped['resize']['height'], function ($constraint) {
                            //$constraint->aspectRatio();
                            // $constraint->upsize();
                        });

                        $image->save($tempPathCropped);

                        Storage::put($newPathCropped, File::get($tempPathCropped), ['public']);

                        // Deleting cropped temp file
                        File::delete($tempPathCropped);
                    }

                }
            } else {
                $image = Image::make($tempPath);
                $image->crop(floor($crop['width']), floor($crop['height']), floor($crop['x']), floor($crop['y']));
                $image->save();
            }

        }

        if (($width || $height)) {
            // Crop image
            $image = Image::make($tempPath);
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->save();
        }

        Storage::put($newPath, File::get($tempPath), ['public']);

        // Deleting temp file
        File::delete($tempPath);

        return $newName;
    }

    /**
     * generateNewFileName function.
     *
     * @access public
     * @static
     * @param mixed $currentFileName
     * @return void
     */
    public static function generateNewFileName($currentFileName)
    {
        $ext = strtolower(File::extension($currentFileName));
        $newName = md5(microtime());

        if ($ext === '') {
            return $newName;
        }

        return $newName . '.' . $ext;
    }

    /**
     * deleteFile function.
     *
     * @access public
     * @static
     * @param mixed $image
     * @param mixed $folder
     * @return void
     */
    public static function deleteFile($image, $folder)
    {
        $dir = trim($folder, '/');
        $path = $dir . '/' . $image;

        if (!File::exists(public_path($path))) {
            Storage::delete($path);
        }

        return true;
    }

    /**
     * deleteDirectory function.
     *
     * @access public
     * @static
     * @param mixed $folder
     * @return void
     */
    public static function deleteDirectory($folder)
    {
        $dir = trim($folder);
        Storage::deleteDirectory($dir);
        return true;
    }
}
