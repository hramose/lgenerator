<?php namespace Fragale\Generators\Commands;

use Fragale\Generators\Generators\ModelGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Fragale\Helpers\PathsInfo;
use Illuminate\Filesystem\Filesystem as File;

class ModelGeneratorCommand extends BaseGeneratorCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'makefast:model';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a new model.';

	/**
	 * Model generator instance.
	 *
	 * @var Fragale\Generators\Generators\ModelGenerator
	 */
	protected $generator;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ModelGenerator $generator)
	{
		parent::__construct();

		$this->generator = $generator;
	}

	/**
	 * Get the path to the file that should be generated.
	 *
	 * @return string
	 */
	protected function getPath()
    	{
		return $this->option('path') . '/' . ucwords($this->argument('name')) . '.php';
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'Name of the model to generate.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		$p=new PathsInfo;
		$file=new File;
		return array(
			array('path', null, InputOption::VALUE_OPTIONAL, 'Path to the models directory.', app_path() . '/cruds'),
			array('template', null, InputOption::VALUE_OPTIONAL, 'Path to template.',$file->name($p->fileModelTemplate()).'.'.$file->extension($p->fileModelTemplate()))
		);
	}

}
