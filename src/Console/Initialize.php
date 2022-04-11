<?php

namespace Boom\Console;

use Boom\Console\BaseCommand;


/**
 * Artisan command to initialize boom controller after installation.
 */
class Initialize extends BaseCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boom:init {--force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize boom controller.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        // Check if boom-controller is already initialized
        if ($this->checkInitialized() && !$this->option('force')) {
            $this->warn('"boom-controller" is already initialized.');
            return;
        }

        // Create config file
        $this->createConfig();

        // Create route file
        $this->createRoute();

        // Create root namespace
        $this->line('');
        $this->call('boom:make:nsp', [
            'name' => '/',
            '--force' => $this->option('force'),
        ]);

        // Print log
        $this->line('');
        $this->info('"boom-controller" is successfully initialized.');
    }


    /**
     * Create config file.
     *
     * @return void
     */
    protected function createConfig() {
        // Prepare destination path
        $dest = $this->path_config;

        // If --force flag is not present and file exists, do nothing
        if (file_exists($dest) && !$this->option('force')) {
            $this->error($dest.' already exists. You can use --force option to overwrite.');
            return;
        }

        // Load stub and prepare to write
        $stub = $this->prepareStub($this->getStub('default_config'));

        // Write file
        $this->laravel['files']->put($dest, $stub);

        // Print log
        $this->info('Config file was created: '.$dest);
    }

    /**
     * Create route file.
     *
     * @return void
     */
    protected function createRoute() {
        // Prepare destination path
        $dest = $this->path_route;

        // If --force flag is not present and file exists, do nothing
        if (file_exists($dest) && !$this->option('force')) {
            $this->error($dest.' already exists. You can use --force option to overwrite.');
            return;
        }

        // Load stub
        $stub = $this->getStub('default_route');

        // Write file
        $this->laravel['files']->put($dest, $stub);

        // Print log
        $this->info('Route file was created: '.$dest);
    }
}
