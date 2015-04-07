<?php
namespace Aindong\CustomGenerator\Commands;

use Aindong\CustomGenerator\Generators\InterfaceGenerator;
use Aindong\CustomGenerator\Generators\ModelGenerator;
use Aindong\CustomGenerator\Generators\ProviderGenerator;
use Aindong\CustomGenerator\Generators\RepositoryGenerator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Aindong\CustomGenerator\Generators\ControllerGenerator;
use Illuminate\Support\Pluralizer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateFeature extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:feature';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a new feature.';

    protected $file;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(File $file)
	{
		parent::__construct();
        $this->file = $file;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $originalName = $this->argument('feature');
        $feature =  Pluralizer::plural(ucfirst($this->argument('feature')));
        $path = $this->option('path');
        $namespace = ucfirst($this->option('namespace'));

        $controllerPath     = $path.'/'.$feature.'/Controllers';
        $modelPath          = $path.'/'.$feature.'/Models';
        $providersPath      = $path.'/'.$feature.'/Providers';
        $repositoriesPath   = $path.'/'.$feature.'/Repositories';

        $this->info('Creating the feature: ' . $feature);
        $this->info('On the path: ' . $path);

        if ($this->confirm('Do you wish to continue? [yes|no]')) {
            $this->info('Creating folders');

            // Creating directories
            $this->createDirectories($path, $feature, $controllerPath, $modelPath, $providersPath, $repositoriesPath);
            $this->file->put($path.'/'.$feature.'/routes.php', '');

            // Create files
            $this->info('Creating controller');
            $controller = new ControllerGenerator($this->file);
            $this->printResult(
                $controller->make($controllerPath.'/'.$feature.'Controller.php', $namespace),
                $controllerPath.'/'.$feature.'Controller.php'
            );

            $this->info('Creating interface');
            $interface = new InterfaceGenerator($this->file);
            $this->printResult(
                $interface->make($repositoriesPath.'/'.ucfirst($originalName).'Interface.php', $namespace),
                $repositoriesPath.'/'.ucfirst($originalName).'Interface.php'
            );

            $this->info('Creating repository');
            $repository = new RepositoryGenerator($this->file);
            $this->printResult(
                $repository->make($repositoriesPath.'/'.ucfirst($originalName).'Repository.php', $namespace),
                $repositoriesPath.'/'.ucfirst($originalName).'Repository.php'
            );

            $this->info('Creating model');
            $model = new ModelGenerator($this->file);
            $this->printResult(
                $model->make($modelPath.'/'.ucfirst($originalName).'.php', $namespace),
                $modelPath.'/'.ucfirst($originalName).'.php'
            );

            $this->info('Creating service provider');
            $provider = new ProviderGenerator($this->file);
            $this->printResult(
                $provider->make($providersPath.'/'.$feature.'ServiceProvider.php', $namespace),
                $providersPath.'/'.$feature.'ServiceProvider.php'
            );
        }
	}

    private function createDirectories($path, $feature, $controllerPath, $modelPath, $providersPath, $repositoriesPath)
    {
        $this->file->makeDirectory($path.'/'.$feature);
        $this->file->makeDirectory($controllerPath);
        $this->file->makeDirectory($modelPath);
        $this->file->makeDirectory($providersPath);
        $this->file->makeDirectory($repositoriesPath);
    }

    /**
     * Provide user feedback, based on success or not.
     *
     * @param  boolean $successful
     * @param  string $path
     * @return void
     */
    protected function printResult($successful, $path)
    {
        if ($successful)
        {
            return $this->info("Created {$path}");
        }
        $this->error("Could not create {$path}");
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('feature', InputArgument::REQUIRED, 'The feature name to be generated.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('path', null, InputOption::VALUE_REQUIRED, 'The path where folders and files will be created.', null),
            array('namespace', null, InputOption::VALUE_REQUIRED, 'This is the namespace of your main packages', null)
		);
	}

}
