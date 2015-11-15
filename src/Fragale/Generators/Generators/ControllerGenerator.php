<?php

namespace Fragale\Generators\Generators;

use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Pluralizer;
use Fragale\Helpers\PathsInfo;

class ControllerGenerator extends Generator {

    public $havehashids;
    public $hashidsting;   
    public $viewDefinitions;
    public $templateCustomsPath;     

    /**
     * Fetch the compiled template for a controller
     *
     * @param  string $template Path to template
     * @param  string $name
     * @return string Compiled template
     */
    protected function getTemplate($template, $className)
    {
        $model = $this->cache->getModelName();  // post
        $models = Pluralizer::plural($model);   // posts

        $this->template = $this->file->get($template);

        $resource = strtolower(Pluralizer::plural(
            str_ireplace('Controller', '', $className)
        ));

       /*lee el json de definiciones*/
        $p=new PathsInfo();    
        $file=new File();
        $this->templateCustomsPath=$p->pathTemplatesCustoms()."/$models/views_definitions.json";
        $path=$this->templateCustomsPath; 
        if (file_exists($path))
        {
            $this->viewDefinitions = json_decode($file->get($path), true);
        } 

        /*use hash ids?*/
        $this->havehashids=false;
        $this->hashidstring='        $useHashid=false;';
        if (isset($this->viewDefinitions['hashids'])){
          $this->havehashids=$this->viewDefinitions['hashids'];
          $this->hashidstring='$id=\Hashids::decode($id)[0];'.PHP_EOL.'        $useHashid=true;';
        }

        if ($this->needsScaffolding($template))
        {
            $this->template = $this->getScaffoldedController($template, $className);
        }

        $template = str_replace('{{className}}', $className, $this->template);
        $template = str_replace('{{hashids}}', $this->hashidstring, $this->template);

        return str_replace('{{collection}}', $resource, $template);
    }

    /**
     * Get template for a scaffold
     *
     * @param  string $template Path to template
     * @param  string $name
     * @return string
     */
    protected function getScaffoldedController($template, $className)
    {
        $model = $this->cache->getModelName();  // post
        $models = Pluralizer::plural($model);   // posts
        $Models = ucwords($models);             // Posts
        $Model = Pluralizer::singular($Models); // Post
        $pictures=$this->arrayOfPictures();

        if($pictures=='array()'){
            $move_pictures='';
        }else{
            $move_pictures="\$this->movePictures(\$$model);";
        }


        foreach(array('model', 'models', 'Models', 'Model', 'className', 'pictures', 'move_pictures') as $var)
        {
            $this->template = str_replace('{{'.$var.'}}', $$var, $this->template);
        }

        return $this->template;
    }
}
