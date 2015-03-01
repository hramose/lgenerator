<?php namespace Fragale\Generators\Commands;


use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem as File;

class NavtabsGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'makefast:navtab';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Crea un archivo de definicion de nav-tabs para las vistas de un recurso especifico.';


	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$resource = $this->argument('resource');
		$tabdef= $this->option('tabdef');
		$this->info('Generando el archivo de definicion de nav-tabs para '.$resource);

		$path=app_path()."/views/$resource/customs";

		$this->info('El directorio donde se grabaran las definiciones es '.$path);

		$file=new File();
		$continue=false;

		if(!$file->exists($path)){
			if ($this->confirm('El directorio no existe, desea crearlo? [yes|no]'))
			{
				$file->makeDirectory($path);
			}
		}
		
		$path=$path."/navtabs.php";

		if($file->exists($path)){
			if ($this->confirm('El archivo ya existe, desea continuar? [yes|no]'))
			{
				$continue=true;
			}
		}else{
			$continue=true;
		}
		if($continue){

        $tabs = preg_split('/, ?/', $tabdef);
        $arrayTabs = array();
        $arrayFields = array();

        foreach($tabs as $pair)
        {
            list($tab, $fieldlist) = preg_split('/ ?: ?/', $pair);
            $arrayTabs[$tab] = $fieldlist;
            $fields=preg_split('/[ ]/', $fieldlist);
            $i=0;
            foreach($fields as $field){
            	$arrayFields[$tab][$i]=$field;
            	$i++;
            }
        }
        	print_r($arrayTabs);
        	print_r($arrayFields);

			$content = json_encode($arrayFields);
			$file->put($path, $content);

			$this->info('Archivo generado.');

		}else{
			$this->info('Proceso abortado.');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('resource', InputArgument::REQUIRED, 'El recurso al que se desea definir los nav-tabs.'),
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
			array('tabdef', null, InputOption::VALUE_REQUIRED, 'Campos indicando tabname:campo campo2 campo3,tabname:campo4, campo5, etc', null),			
		);
	}

}
