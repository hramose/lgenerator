<?php

namespace Fragale\Generators\Generators;

use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem as File;

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

        /*Crea las reglas*/
        /*Verifica si hay reglas definidas por el usuarios*/
        $path=app_path()."/views/$models/customs/rules.php";
        if (file_exists($path))
        {
            /*si existen las reglas de usuario entones la importa */
            $file=new File();
            $rules =$file->get($path);
            $this->template = str_replace('{{rules}}', $rules, $this->template);

        }else{
            /*si no existen entonces las crea*/
            if (! $fields = $this->cache->getFields())
            {
                $this->template = str_replace('{{rules}}', '', $this->template);
            } else {

                $rules = array_map(function($field) {
                    return "'$field' => 'required'";
                }, array_keys($fields));

                $this->template = str_replace('{{rules}}', PHP_EOL."\t\t".implode(','.PHP_EOL."\t\t", $rules) . PHP_EOL."\t", $this->template);
            }
        }

        /*cambia el resto del template*/
        foreach(array('model', 'models', 'Models', 'Model') as $var)
        {
            $this->template = str_replace('{{'.$var.'}}', $$var, $this->template);
        }

        return $this->template;
    }

}
