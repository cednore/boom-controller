<?php

namespace Boom\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;


/**
 * Base class for artisan commands.
 */
class BaseCommand extends Command {
    /**
     * Path to boom config file.
     *
     * @var string
     */
    protected $path_config = null;

    /**
     * Path to boom route file.
     *
     * @var string
     */
    protected $path_route = null;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

        // Prepare default paths
        $this->path_config = config_path('boom.php');
        $this->path_route = base_path('routes/boom.php');
    }


    /**
     * Check if boom-controller is initialized already.
     *
     * @return bool
     */
    protected function checkInitialized() {
        return file_exists($this->path_config) && file_exists($this->path_route);
    }

    /**
     * Get stub contents.
     *
     * @param  string  $name
     * @return string
     */
    protected function getStub(string $name) {
        return $this->laravel['files']->get(__DIR__."/stubs/$name.stub");
    }

    /**
     * Create the directory to house the published files if needed.
     *
     * @param  string  $directory
     * @return void
     */
    protected function createParentDirectory(string $directory) {
        if (!$this->laravel['files']->isDirectory($directory)) {
            $this->laravel['files']->makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Replace pre-defined strings to prepare stub.
     *
     * @param  string  $stub
     * @param  string  $newNsp
     * @return string
     */
    protected function prepareStub(string $stub, string $newNsp = null) {
        $stub = str_replace('[PrjNamespace]', laravel_project_root_namespace(), $stub);

        if (null != $newNsp) {
            $stub = str_replace('[new_nsp_name]', $newNsp, $stub);
            $stub = str_replace('[NewNspName]', $this->makeControllerName($newNsp, false), $stub);
        }

        return $stub;
    }

    /**
     * Make controller name from io namespace name.
     *
     * @param  string  $name
     * @param  bool  $suffix
     * @return string
     */
    protected function makeControllerName(string $name, bool $suffix = true) {
        $controller = Str::studly('/' == $name ? 'root' : Str::slug($name));

        if (true == $suffix) {
            $controller = $controller.'Controller';
        }

        return $controller;
    }
}
