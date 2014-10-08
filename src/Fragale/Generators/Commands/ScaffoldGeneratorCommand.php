<?php namespace Fragale\Generators\Commands;

use Fragale\Generators\Generators\ResourceGenerator;
use Fragale\Generators\Cache;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;

class MissingTableFieldsException extends \Exception {}

class ScaffoldGeneratorCommand extends ResourceGeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'makefast:scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate scaffolding for a resource.';

    /**
     * Get the path to the template for a model.
     *
     * @return string
     */
    protected function getModelTemplatePath()
    {
        $filename=__DIR__.'/../Generators/templates/scaffold/model.txt';
        $models = Pluralizer::plural($this->model);
        $customFile=app_path().'/views/'.$models.'/customs/model_scaffold.php';
        if (file_exists($customFile)){
            $filename=$customFile;
            $this->info('Using custom file :'.$customFile);
        }
        return $filename;        
    }

    /**
     * Get the path to the template for a controller.
     *
     * @return string
     */
    protected function getControllerTemplatePath()
    {
        $filename=__DIR__.'/../Generators/templates/scaffold/controller.txt';
        $models = Pluralizer::plural($this->model);
        $customFile=app_path().'/views/'.$models.'/customs/controller_scaffold.php';
        if (file_exists($customFile)){
            $filename=$customFile;
            $this->info('Using custom file :'.$customFile);
        }
        return $filename;
    }


    /**
     * Get the path to the template for a controller.
     *
     * @return string
     */
    protected function getTestTemplatePath()
    {
        return __DIR__.'/../Generators/templates/scaffold/controller-test.txt';
    }

    /**
     * Get the path to the template for a view.
     *
     * @return string
     */
    protected function getViewTemplatePath($view = 'view')
    {
        return __DIR__."/../Generators/templates/scaffold/views/{$view}.txt";
    }

}