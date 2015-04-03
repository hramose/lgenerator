<?php

namespace Fragale\Generators\Generators;

use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem as File;
use Fragale\Helpers\PathsInfo;

class ModelGenerator extends Generator {

    /**
     * Fetch the compiled template for a model
     *
     * @param  string $template Path to template
     * @param  string $className
     * @return string Compiled template
     */
    protected function getTemplate($template, $className)
    {
        $this->template = $this->file->get($template);

        if ($this->needsScaffolding($template))
        {
            $this->template = $this->getScaffoldedModel($className);
        } else {
            echo "no necesita scaffold !!! \n";
        }

        return str_replace('{{className}}', $className, $this->template);
    }

    /**
     * Get template for a scaffold
     *
     * @param  string $template Path to template
     * @param  string $name
     * @return string
     */
    protected function getScaffoldedModel($className)
    {
        $model = $this->cache->getModelName();  // post
        $models = Pluralizer::plural($model);   // posts
        $Models = ucwords($models);             // Posts
        $Model = Pluralizer::singular($Models); // Post

        $file=new File();
        $p=new PathsInfo;
        $templateCustomsPath=$p->pathTemplatesCustoms()."/$models";

        /*Crea las reglas*/
        /*Verifica si hay reglas definidas por el usuarios*/
        $path="$templateCustomsPath/rules.php";
        $model_rules='';
        if (file_exists($path))
        {
            $model_rules = $this->purgePHPTags(PHP_EOL.$file->get($path).PHP_EOL);

        }else{
            /*si no existen entonces las crea*/
            if (! $fields = $this->cache->getFields())
            {
                $model_rules ='/*no rules*/';
            } else {

                $rules = array_map(function($field) {
                    return "'$field' => 'required'";
                }, array_keys($fields));

                $model_rules = $this->makeRules($rules);
            }
        }



        /*hay algo que agregar al modelo?*/
        $path="$templateCustomsPath/append_to_model.template.php";
        $append_to_model="";
        if (file_exists($path))
        {
            $append_to_model = $this->purgePHPTags(PHP_EOL.$file->get($path).PHP_EOL);
        }


        /*cambia el resto del template*/
        foreach(array('model', 'models', 'Models', 'Model', 'append_to_model', 'model_rules') as $var)
        {
            $this->template = str_replace('{{'.$var.'}}', $$var, $this->template);
        }

        return $this->template;
    }

    /**
     * Remove the php tags from a text
     *
     * @return string
     */
    public function purgePHPTags($text){
      return str_replace('<?php', '', $text);
    }


    /**
     * Make de static rules section for the model
     *
     * @return string
     */
    public function makeRules($rules){

      return 'public static $rules = array('.PHP_EOL."\t\t".implode(','.PHP_EOL."\t\t", $rules) . PHP_EOL."\t);";
                            
      
    }

}
