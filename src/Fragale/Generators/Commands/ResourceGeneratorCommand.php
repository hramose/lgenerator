<?php namespace Fragale\Generators\Commands;

use Fragale\Generators\Cache;
use Fragale\Generators\Generators\ResourceGenerator;
use Fragale\Helpers\PathsInfo;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Pluralizer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MissingFieldsException extends \Exception {}

class ResourceGeneratorCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'makefast:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a resource.';

    /**
     * Model generator instance.
     *
     * @var Fragale\Generators\Generators\ResourceGenerator
     */
    protected $generator;

    /**
     * File cache.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ResourceGenerator $generator, Cache $cache)
    {
        parent::__construct();

        $this->generator = $generator;
        $this->cache = $cache;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // Scaffolding should alfragales begin with the singular
        // form of the now.
        $this->model = Pluralizer::singular($this->argument('name'));

        $this->fields = $this->option('fields');

        if (is_null($this->fields))
        {
            throw new MissingFieldsException('You must specify the fields option.');
        }

        // We're going to need access to these values
        // within future commands. I'll save them
        // to temporary files to allow for that.
        $this->cache->fields($this->fields);
        $this->cache->modelName($this->model);

        $this->generateModel();
        $this->generateController();
        $this->generateViews();
        //$this->generateMigration();
        //$this->generateSeed();

        if (get_called_class() === 'Fragale\\Generators\\Commands\\ScaffoldGeneratorCommand')
        {
            //No genera los tests
            //$this->generateTest();
        }

        $this->generator->updateRoutesFile($this->model);
        $this->info('Updated ' . app_path() . '/routes.php');

        // We're all finished, so we
        // can delete the cache.
        $this->cache->destroyAll();
    }

    /**
     * Get the path to the template for a model.
     *
     * @return string
     */
    protected function getModelTemplatePath()
    {
        return __DIR__.'/../Generators/templates/model.txt';
    }

    /**
     * Get the path to the template for a controller.
     *
     * @return string
     */
    protected function getControllerTemplatePath()
    {
        return __DIR__.'/../Generators/templates/controller.txt';
    }

    /**
     * Get the path to the template for a view.
     *
     * @return string
     */
    protected function getViewTemplatePath($view = 'view')
    {
        return __DIR__."/../Generators/templates/view.txt";
    }

    /**
     * Call makefast:model
     *
     * @return void
     */
    protected function generateModel()
    {
        // For now, this is just the regular model template
        $this->call(
            'makefast:model',
            array(
                'name' => $this->model,
                '--template' => $this->getModelTemplatePath()
            )
        );
    }

    /**
     * Call makefast:controller
     *
     * @return void
     */
   protected function generateController()
    {
        $name = Pluralizer::plural($this->model);

        $this->call(
            'makefast:controller',
            array(
                'name' => "{$name}Controller",
                '--template' => $this->getControllerTemplatePath()
            )
        );
    }

    /**
     * Call makefast:test
     *
     * @return void
     */
    protected function generateTest()
    {
        if ( ! file_exists(app_path() . '/tests/controllers'))
        {
            mkdir(app_path() . '/tests/controllers');
        }

        $this->call(
            'makefast:test',
            array(
                'name' => Pluralizer::plural(strtolower($this->model)) . 'Test',
                '--template' => $this->getTestTemplatePath(),
                '--path' => app_path() . '/tests/controllers'
            )
        );
    }

    /**
     * Call makefast:views
     *
     * @return void
     */
    protected function generateViews()
    {
        $p=new PathsInfo;
        $file=new File();
        $viewsDir = $p->pathViews().'/cruds';
        $container = $viewsDir . '/' . Pluralizer::plural($this->model);
        $layouts = $viewsDir . '/layouts';
        $views = array('index', 'show', 'create', 'edit');
        $models=Pluralizer::plural($this->model);


        $path=$p->pathTemplatesCustoms()."/$models/views_definitions.json";
        if (file_exists($path))
        {
            $this->viewDefinitions = json_decode($file->get($path), true);
        }

        if (isset($this->viewDefinitions['only_generate_views'])){
            $views = $this->viewDefinitions['only_generate_views'];
        } else {
            $views = ['index', 'show', 'create', 'edit'];
        }

        $this->generator->folders(
            array($container)
        );

        // Let's filter through all of our needed views
        // and create each one.
        foreach($views as $view)
        {
            $path = $view === 'scaffold' ? $layouts : $container;
            $this->generateView($view, $path);
        }
    }

    /**
     * Generate a view
     *
     * @param  string $view
     * @param  string $path
     * @return void
     */
    protected function generateView($view, $path)
    {
        $this->call(
            'makefast:view',
            array(
                'name'       => $view,
                '--path'     => $path,
                '--template' => $this->getViewTemplatePath($view)
            )
        );
    }

    /**
     * Call makefast:migration
     *
     * @return void
     */
    protected function generateMigration()
    {
        /*
        $name = 'create_' . Pluralizer::plural($this->model) . '_table';

        $this->call(
            'makefast:migration',
            array(
                'name'      => $name,
                '--fields'  => $this->option('fields')
            )
        );
        */
    }

    protected function generateSeed()
    {
        /*
        $this->call(
            'makefast:seed',
            array(
                'name' => Pluralizer::plural(strtolower($this->model))
            )
        );
        */
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the desired resource.'),
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
            array('path', null, InputOption::VALUE_OPTIONAL, 'The path to the migrations folder', app_path() . '/database/migrations'),
            array('fields', null, InputOption::VALUE_OPTIONAL, 'Table fields', null),
            array('purge', null, InputOption::VALUE_OPTIONAL, 'First remove the actual scaffold for this resource', null)

        );
    }

}
