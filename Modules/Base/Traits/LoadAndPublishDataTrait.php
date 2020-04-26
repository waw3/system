<?php

namespace Modules\Base\Traits;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * @mixin ServiceProvider
 */
trait LoadAndPublishDataTrait
{
    /**
     * @var string
     */
    protected $namespace = null;

    /**
     * @var string
     */
    protected $basePath = null;

    /**
     * @param $namespace
     * @return $this
     */
    public function setNamespace($namespace): self
    {
        $this->namespace = ltrim(rtrim($namespace, '/'), '/');
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setBasePath($path): self
    {
        $this->basePath = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath ?? plugin_path();
    }

    /**
     * Publish the given configuration file name (without extension) and the given module
     * @param $fileNames
     * @return $this
     */
    public function loadAndPublishConfigurations($fileNames): self
    {

        $fileNames = (!is_array($fileNames) ? [$fileNames] : $fileNames ) ;

        foreach ($fileNames as $fileName) {
            $this->mergeConfigFrom($this->getConfigFilePath($fileName), $this->getDotedNamespace() . '.' . $fileName);

            if ($this->app->runningInConsole()) {
                $this->publishes([
                    $this->getConfigFilePath($fileName) => config_path($this->getDashedNamespace() . '/' . $fileName . '.php'),
                ], 'cms-config');
            }
        }

        return $this;
    }

    /**
     * Publish the given configuration file name (without extension) and the given module
     * @param $fileNames
     * @return $this
     */
    public function loadRoutes($fileNames = ['web']): self
    {

        $fileNames = (!is_array($fileNames) ? [$fileNames] : $fileNames ) ;

        foreach ($fileNames as $fileName) {
            $this->loadRoutesFrom($this->getRouteFilePath($fileName));
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function loadAndPublishViews(): self
    {

//         dd($this->getViewsPath(), $this->getDashedNamespace(), $this->getDotedNamespace());
        $this->loadViewsFrom($this->getViewsPath(), $this->getDotedNamespace());

        if ($this->app->runningInConsole()) {
            $this->publishes([$this->getViewsPath() => resource_path('views/vendor/' . $this->getDashedNamespace())],
                'cms-views');
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function loadAndPublishTranslations(): self
    {
        $this->loadTranslationsFrom($this->getTranslationsPath(), $this->getDotedNamespace());

        if ($this->app->runningInConsole()) {
            $this->publishes([$this->getTranslationsPath() => resource_path('lang/vendor/' . $this->getDashedNamespace())],
                'cms-lang');
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function loadMigrations(): self
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());
        return $this;
    }

    /**
     * @param null $path
     * @return $this
     * @deprecated
     */
    public function publishPublicFolder($path = null): self
    {
        return $this->publishAssets($path);
    }

    /**
     * @param null $path
     * @return $this
     * @deprecated
     */
    public function publishAssetsFolder(): self
    {
        return $this->publishAssets();
    }

    /**
     * @param null $path
     * @return $this
     */
    public function publishAssets($path = null): self
    {
        if ($this->app->runningInConsole()) {
            if (empty($path)) {
                $path = !Str::contains($this->getDotedNamespace(), 'core.') ? 'vendor/' . $this->getDashedNamespace() : 'vendor/core';
            }
            $this->publishes([$this->getAssetsPath() => public_path($path)], 'cms-public');
        }

        return $this;
    }

    /**
     * Get path of the give file name in the given module
     * @param string $file
     * @return string
     */
    protected function getConfigFilePath($file): string
    {


        return $this->getBasePath() . str_replace('modules/plugins/', '', $this->getDashedNamespace()) . '/config/' . $file . '.php';
    }

    /**
     * @param $file
     * @return string
     */
    protected function getRouteFilePath($file): string
    {
        return $this->getBasePath() . str_replace('modules/plugins/', '', $this->getDashedNamespace()) . '/routes/' . $file . '.php';
    }

    /**
     * @return string
     */
    protected function getViewsPath(): string
    {
        return $this->getBasePath() . str_replace('modules/plugins/', '', $this->getDashedNamespace()) . '/resources/views/';
    }

    /**
     * @return string
     */
    protected function getTranslationsPath(): string
    {
        return $this->getBasePath() . str_replace('modules/plugins/', '', $this->getDashedNamespace()) . '/resources/lang/';
    }

    /**
     * @return string
     */
    protected function getMigrationsPath(): string
    {
        return $this->getBasePath() . str_replace('modules/plugins/', '', $this->getDashedNamespace()) . '/database/migrations/';
    }

    /**
     * @return string
     */
    protected function getAssetsPath(): string
    {
        return $this->getBasePath() . str_replace('modules/plugins/', '', $this->getDashedNamespace()) . '/public/';
    }

    /**
     * @return string
     */
    protected function getDotedNamespace(): string
    {
        return str_replace('/', '.', $this->namespace);
    }

    /**
     * @return string
     */
    protected function getDashedNamespace(): string
    {
        return str_replace('.', '/', $this->namespace);
    }
}
