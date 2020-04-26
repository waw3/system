<?php

namespace Modules\Plugins\Translation\Console;

use Modules\Plugins\Translation\Manager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class ImportCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cms:translations:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import translations from the PHP sources';

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * ImportCommand constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Importing...');
        $replace = $this->option('replace');
        $counter = $this->manager->importTranslations($replace);
        $this->info('Done importing, processed ' . $counter . ' items!');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['replace', 'R', InputOption::VALUE_NONE, 'Replace existing keys'],
        ];
    }
}