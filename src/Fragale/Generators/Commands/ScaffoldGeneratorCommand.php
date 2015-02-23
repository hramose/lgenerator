<?php namespace Fragale\Generators\Commands;

use Fragale\Generators\Generators\ResourceGenerator;
use Fragale\Generators\Cache;
use Fragale\Helpers\PathsInfo;
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
        $models = Pluralizer::plural($this->model);
        $p=new PathsInfo();
        $filename=$p->testAndSwapFileName(__DIR__.'/../Generators/templates/scaffold/model.php', $p->fileModelTemplate());
        $filename=$p->testAndSwapFileName($filename, $p->fileCustomModel($models));
        $this->info('Template model file for this object: '.$filename);
        return $filename;        
    }

    /**
     * Get the path to the template for a controller.
     *
     * @return string
     */
    protected function getControllerTemplatePath()
    {
        $models = Pluralizer::plural($this->model);
        $p=new PathsInfo();
        $filename=$p->testAndSwapFileName(__DIR__.'/../Generators/templates/scaffold/controller.php', $p->fileControllerTemplate());
        $filename=$p->testAndSwapFileName($filename, $p->fileCustomController($models));
        $this->info('Template controller file for this object: '.$filename);
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
    protected function getViewTemplatePath($view = 'view') /*CONTINUAR AQUI crear el metodo en $p */
    {
        return __DIR__."/../Generators/templates/scaffold/views/{$view}.txt";

        $models = Pluralizer::plural($this->model);
        $p=new PathsInfo();
        $filename=$p->testAndSwapFileName(__DIR__."/../Generators/templates/scaffold/views/{$view}.txt", $p->fileControllerTemplate());
        $filename=$p->testAndSwapFileName($filename, $p->fileCustomController($models));
        $this->info('Template controller file for this object: '.$filename);
        return $filename;     


    }

}