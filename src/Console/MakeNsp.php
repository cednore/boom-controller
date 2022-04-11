<?php

namespace Boom\Console;

use Boom\Console\BaseCommand;
use Illuminate\Support\Str;


/**
 * Artisan command to make a new socket.io namespace handler.
 */
class MakeNsp extends BaseCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boom:make:nsp
                            {name : Name of new namespace to create.}
                            {--force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new socket.io namespace handler.';

    /**
     * Name of new namespace to create.
     *
     * @var string
     */
    protected $newNspName = null;


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        // Check if boom-controller is already initialized
        if (!$this->checkInitialized()) {
            $this->error('"boom-controller" is not initialized yet. Run "boom:init" first.');
            return;
        }

        // Prepare new namespace name
        $this->newNspName = '/' !== ($this->argument('name'))[0]
            ? '/'.$this->argument('name')
            : $this->argument('name');

        // Add new routes
        $this->insertRoute();

        // Create default controller file
        $this->createController();

        // Re-optimize route cache
        $this->callSilent('route:cache');
    }


    /**
     * Add new routes into exisitng route file.
     *
     * @return void
     */
    protected function insertRoute() {
        // Prepare destination path
        $dest = base_path('routes/boom.php');

        // Check if destination route file exists
        if (!file_exists($dest)) {
            $this->error('Boom route file not found! Run "boom:init" first to initialize.');
            return;
        }

        // Load stub and prepare to write
        $stub = $this->prepareStub($this->getStub('default_route_nsp'), $this->newNspName);

        // Append to route file
        $this->laravel['files']->append($dest, $stub);

        // Print log
        $this->info('Inserted new routes for namespace "'.$this->newNspName.'".');
    }

    /**
     * Create controller file.
     *
     * @return void
     */
    protected function createController() {
        // Prepare controller name
        $controller = $this->makeControllerName($this->newNspName);

        // Prepare destination path
        $dest = base_path(Str::replace(config('boom.route.namespace'), "\\", '/').'/'.$controller.'.php');
        $this->createParentDirectory(dirname($dest));

        // If --force flag is not present and file exists, do nothing
        if (file_exists($dest) && !$this->option('force')) {
            $this->error($dest.' already exists. You can use --force option to overwrite.');
            return;
        }

        // Load stub and prepare to write
        $stub = $this->prepareStub($this->getStub('default_controller'), $this->newNspName);

        // Write file
        $this->laravel['files']->put($dest, $stub);

        // Print log
        $this->info('"'.$controller.'" is created.');
    }
}
