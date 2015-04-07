<?php 
namespace Aindong\CustomGenerator\Providers;

use Aindong\CustomGenerator\Commands\GenerateFeature;
use Illuminate\Support\ServiceProvider;

class CustomGeneratorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerCommands();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Register the command into the application
	 */
	public function registerCommands()
    {
        $this->app['commands.aindong.generatefeature'] = $this->app->share(function($app) {
            return new GenerateFeature($app['files']);
        });

        $this->commands('commands.aindong.generatefeature');
    }

}
