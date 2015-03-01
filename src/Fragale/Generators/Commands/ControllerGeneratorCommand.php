<?php namespace Fragale\Generators\Commands;

use Fragale\Generators\Generators\ControllerGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Fragale\Helpers\PathsInfo;
use Illuminate\Filesystem\Filesystem as File;

class ControllerGeneratorCommand extends BaseGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'makefast:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new controller.';

    /**
     * Model generator instance.
     *
     * @var Fragale\Generators\Generators\ControllerGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ControllerGenerator $generator)
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
            array('name', InputArgument::REQUIRED, 'Name of the controller to generate.'),
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
           array('path', null, InputOption::VALUE_OPTIONAL, 'Path to controllers directory.', app_path().'/Http/Controllers/cruds'),
           array('template', null, InputOption::VALUE_OPTIONAL, 'Path to template.', $file->name($p->fileControllerTemplate()).'.'.$file->extension($p->fileControllerTemplate())),
        );
    }

}
