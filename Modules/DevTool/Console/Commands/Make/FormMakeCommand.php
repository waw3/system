<?php

namespace Modules\DevTool\Console\Commands\Make;

use Modules\DevTool\Console\Commands\Abstracts\BaseMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class FormMakeCommand extends BaseMakeCommand
{
    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cms:make:form {name : The table that you want to create} {module : module name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a form';

    /**
     * Create a new key generator command.
     *
     * @param Filesystem $files
     *
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!preg_match('/^[a-z0-9\-\_]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return false;
        }

        $arg_name = $this->argument('name');
        $arg_module = $this->argument('module');

        $module = Module::findOrFail($arg_module);
        $path = modules_path($module->getName(). '/Forms/' . ucfirst(Str::studly($arg_name)) . 'Form.php');

        $this->publishStubs($this->getStub(), $path);
        $this->renameFiles($arg_name, $path);
        $this->searchAndReplaceInFiles($arg_name, $path);
        $this->line('------------------');

        $this->info('Create successfully!');

        return true;
    }

    /**
     * @return string
     */
    public function getStub(): string
    {
        return __DIR__ . '/../../../Resources/stubs/module/src/Forms/{Name}Form.stub';
    }

    /**
     * @param string $replaceText
     * @return array
     */
    public function getReplacements(string $replaceText): array
    {
        return [];
    }
}
