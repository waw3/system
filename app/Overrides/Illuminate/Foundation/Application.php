<?php namespace App\Overrides\Illuminate\Foundation;

use Illuminate\Foundation\Application as IlluminateApplication;

/**
 * Class     Application
 *
 * @package  App
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Application extends IlluminateApplication
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */


    /**
     * Get the path to the bootstrap directory.
     *
     * @param  string  $path Optionally, a path to append to the bootstrap path
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath($path = '')
    {
        return $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'public' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath($path = '')
    {
        return $this->storagePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'storage' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the resources directory.
     *
     * @param  string  $path
     * @return string
     */
    public function resourcePath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function modelsPath($path = '')
    {
        return $this->path . DIRECTORY_SEPARATOR . 'Models' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config'.($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application modules files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function modulesPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'Modules'. ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application themes files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function themesPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'Themes'. ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @param  string  $path
     * @return string
     */
    public function path($path = '')
    {
        $appPath = $this->appPath ?: $this->basePath . DIRECTORY_SEPARATOR . 'app';

        return $appPath.($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the database directory.
     *
     * @param  string  $path Optionally, a path to append to the database path
     * @return string
     */
    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'database').($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application themes files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function uploadsPath($path = '')
    {
        return $this->storagePath . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public'.($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application storage files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function storageUrl($path = '')
    {
        return URL_SEPARATOR . 'storage' . ($path ? URL_SEPARATOR . $path : $path);
    }

    /**
     * Get the url to the application stprage public files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function uploadsUrl($path = '')
    {
        return URL_SEPARATOR . 'storage' . URL_SEPARATOR . 'uploads' . ($path ? URL_SEPARATOR . $path : $path);
    }
}
