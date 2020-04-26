<?php namespace App\Helpers\Classes;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;


/**
 * DirectoryHelper class.
 */
class DirectoryHelper
{
    public static function size($path)
    {
        $total = 0;
        $path = realpath($path);
        if ($path !== false) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $total += $object->getSize();
            }
        }
        return $total;
    }
}
