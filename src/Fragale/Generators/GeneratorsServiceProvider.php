<?php namespace Fragale\Generators;

use Fragale\Generators\Commands;
use Fragale\Generators\Generators;
use Fragale\Generators\Cache;
use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider {

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
		//$this->registerTestGenerator();
		//$this->registerMigrationGenerator();
		//$this->registerSeedGenerator();
		$this->registerModelGenerator();
		$this->registerControllerGenerator();
		$this->registerResourceGenerator();
		$this->registerScaffoldGenerator();
		$this->registerViewGenerator();
		$this->registerPivotGenerator();
		$this->registerFormDumper();

		$this->registerNavtabsGenerator();
		$this->registerCrudStructureGenerator();
		$this->registerCrudRemoveCommand();

		$this->commands(
			//'makefast.test',
			//'makefast.migration',
			//'makefast.seed',
			'makefast.navtabs',
			'makefast.remove',
			'makefast.crudstructure',
			'makefast.model',
			'makefast.controller',
			'makefast.scaffold',
			'makefast.resource',
			'makefast.view',
			'makefast.form',
			'makefast.pivot'
		);
	}


	/**
	 * Register generate:navtabs
	 *
	 * @return Commands\NavtabsGeneratorCommand;
	 */
	protected function registerNavtabsGenerator()
	{
		$this->app['makefast.navtabs'] = $this->app->share(function($app)
		{
			return new Commands\NavtabsGeneratorCommand;
		});
	}


	protected function registerCrudRemoveCommand()
	{
		$this->app['makefast.remove'] = $this->app->share(function($app)
		{
			return new Commands\CrudRemoveCommand;
		});
	}

	protected function registerCrudStructureGenerator()
	{
		$this->app['makefast.crudstructure'] = $this->app->share(function($app)
		{

			return new Commands\CrudStructureGeneratorCommand;
		});
	}

	/**
	 * Register generate:model
	 *
	 * @return Commands\ModelGeneratorCommand
	 */
	protected function registerModelGenerator()
	{
		$this->app['makefast.model'] = $this->app->share(function($app)
		{
			$cache = new Cache($app['files']);
			$generator = new Generators\ModelGenerator($app['files'], $cache);

			return new Commands\ModelGeneratorCommand($generator);
		});
	}

	/**
	 * Register generate:controller
	 *
	 * @return Commands\ControllerGeneratorCommand
	 */
	protected function registerControllerGenerator()
	{
		$this->app['makefast.controller'] = $this->app->share(function($app)
		{
			$cache = new Cache($app['files']);
			$generator = new Generators\ControllerGenerator($app['files'], $cache);

			return new Commands\ControllerGeneratorCommand($generator);
		});
	}


	/**
	 * Register generate:view
	 *
	 * @return Commands\ViewGeneratorCommand
	 */
	protected function registerViewGenerator()
	{
		$this->app['makefast.view'] = $this->app->share(function($app)
		{
			$cache = new Cache($app['files']);
			$generator = new Generators\ViewGenerator($app['files'], $cache);

			return new Commands\ViewGeneratorCommand($generator);
		});
	}

	/**
	 * Register generate:scaffold
	 *
	 * @return Commands\ScaffoldGeneratorCommand
	 */
	protected function registerScaffoldGenerator()
	{
		$this->app['makefast.scaffold'] = $this->app->share(function($app)
		{
			$generator = new Generators\ResourceGenerator($app['files']);
			$cache = new Cache($app['files']);

			return new Commands\ScaffoldGeneratorCommand($generator, $cache);
		});
	}

	/**
	 * Register generate:resource
	 *
	 * @return Commands\ResourceGeneratorCommand
	 */
	protected function registerResourceGenerator()
	{
		$this->app['makefast.resource'] = $this->app->share(function($app)
		{
			$cache = new Cache($app['files']);
			$generator = new Generators\ResourceGenerator($app['files'], $cache);

			return new Commands\ResourceGeneratorCommand($generator, $cache);
		});
	}

	/**
	 * Register generate:pivot
	 *
	 * @return Commands\PivotGeneratorCommand
	 */
	protected function registerPivotGenerator()
	{
		$this->app['makefast.pivot'] = $this->app->share(function($app)
		{
			return new Commands\PivotGeneratorCommand;
		});
	}

	/**
	 * Register generate:migration
	 *
	 * @return Commands\FormDumperCommand
	 */
	protected function registerFormDumper()
	{
		$this->app['makefast.form'] = $this->app->share(function($app)
		{
			$gen = new Generators\FormDumperGenerator($app['files'], new \Mustache_Engine);

			return new Commands\FormDumperCommand($gen);
		});
	}

	/**
	 * Register generate:test
	 *
	 * @return Commands\TestGeneratorCommand
	 */
	/*
	protected function registerTestGenerator()
	{
		$this->app['makefast.test'] = $this->app->share(function($app)
		{
			$cache = new Cache($app['files']);
			$generator = new Generators\TestGenerator($app['files'], $cache);

			return new Commands\TestGeneratorCommand($generator);
		});
	}
	*/
	/**
	 * Register generate:seed
	 *
	 * @return Commands\SeedGeneratorCommand
	 */
	/*
	protected function registerSeedGenerator()
	{
		$this->app['makefast.seed'] = $this->app->share(function($app)
		{
			$cache = new Cache($app['files']);
			$generator = new Generators\SeedGenerator($app['files'], $cache);

			return new Commands\SeedGeneratorCommand($generator);
		});
	}
*/
	/**
	 * Register generate:migration
	 *
	 * @return Commands\MigrationGeneratorCommand
	 */
	/*
	protected function registerMigrationGenerator()
	{
		$this->app['makefast.migration'] = $this->app->share(function($app)
		{
			$cache = new Cache($app['files']);
			$generator = new Generators\MigrationGenerator($app['files'], $cache);

			return new Commands\MigrationGeneratorCommand($generator);
		});
	}
*/
	
}
