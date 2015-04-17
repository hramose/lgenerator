<?php

namespace Fragale\Generators\Generators;

use Fragale\Generators\Cache;
use Illuminate\Filesystem\Filesystem as File;

class RequestedCacheNotFound extends \Exception {}

abstract class Generator {

    /**
     * File path to generate
     *
     * @var string
     */
    public $path;

    /**
     * File system instance
     * @var File
     */
    protected $file;

    /**
     * Cache
     * @var Cache
     */
    protected $cache;

    /**
     * Constructor
     *
     * @param $file
     */
    public function __construct(File $file, Cache $cache)
    {
        $this->file = $file;
        $this->cache = $cache;
    }

    /**
     * Compile template and generate
     *
     * @param  string $path
     * @param  string $template Path to template
     * @return boolean
     */
    public function make($path, $template)
    {
        $this->name = basename($path, '.php');
        $this->path = $this->getPath($path);
        $template = $this->getTemplate($template, $this->name);

        if (! $this->file->exists($this->path))
        {
            return $this->file->put($this->path, $template) !== false;
        }

        return false;
    }

    /**
     * Get the path to the file
     * that should be generated
     *
     * @param  string $path
     * @return string
     */
    protected function getPath($path)
    {
        // By default, we won't do anything, but
        // it can be overridden from a child class
        return $path;
    }

    /**
     * Determines whether the specified template
     * points to the scaffolds directory
     *
     * @param  string $template
     * @return boolean
     */
    protected function needsScaffolding($template)
    {
        
        return str_contains($template, '.template.');
    }

    /**
     * Get compiled template
     *
     * @param  string $template
     * @param  $name Name of file
     * @return string
     */
    abstract protected function getTemplate($template, $name);

    /**
     * 
     * 
     *
     * @return string
     */
    public function fieldAttributes($name, $type)
    {
        
        preg_match('/\(([^)]+)\)/', $type, $lensinfo);

        $type_pure=$type;
        $field_detail['name']=$name;
        if (isset($lensinfo[0])){
          $type_pure=str_replace($lensinfo[0], '', $type);
          $field_detail['len']=$lensinfo[1];
          if(strpos($field_detail['len'],'x')){
            list($width, $height)=explode('x', $field_detail['len']);
            $field_detail['width']=$width;
            $field_detail['height']=$height;
          }
        }
        $field_detail['type']=$type_pure;

        return $field_detail;
    }

    /**
    * 
    * Devuelve un array con los nombres de los campos que son pictures.
    *
    * @return array
    */
    public function havePicture()
    {
        $this->arrayOfPictures ="array()";
        $fields = $this->cache->getFields();
        $result = false;
        $names='';
        foreach ($fields as $name => $type) {
            $field=$this->fieldAttributes($name, $type);
            if ($field['type']=='picture'){
                $names=$names."'$name' ";
            }            
        }
        if($names!=''){
            $result='['.str_replace(' ',',',trim($names)).']';
            $this->arrayOfPictures = explode(' ', trim($names));
        }
        return $result;
    }



}