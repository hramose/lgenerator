<?php

namespace Fragale\Generators\Generators;

use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Pluralizer;

class ScaffoldGenerator {

    /**
     * File system instance
     *
     * @var File
     */
    protected $file;

    /**
     * Constructor
     *
     * @param $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Update app/Http/routes.php  ESTE METODO APARENTEMENTE NO ESTA FUNCIONANDO xQ SE ESTA USANDO EL DE ResourceGenerator.php
     *
     * @param  string $name
     * @return void
     */
    /*
    public function updateRoutesFile($name)
    {
        $name = strtolower(Pluralizer::plural($name));
        $path = app_path() . '/Http/routes.php';
        $file=new File();

        $append="\n\nRoute::resource('" . $name . "', 'cruds\\" . ucwords($name) . "Controller');";
        $buffer=$file->get($path);

        if ( !Str::contains( $buffer, $append) ) {       
            $this->file->append($path, $append);
        }
    }
    */

    /**
     * Create any number of folders
     *
     * @param  string|array $folders
     * @return void
     */
    public function folders($folders)
    {
        foreach((array) $folders as $folderPath)
        {
            if (! $this->file->exists($folderPath))
            {
                $this->file->makeDirectory($folderPath);
            }
        }
    }

}