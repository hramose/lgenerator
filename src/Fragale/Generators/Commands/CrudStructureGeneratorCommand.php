<?php namespace Fragale\Generators\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem as File;
use Fragale\Helpers\PathsInfo;

class CrudStructureGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'makefast:crudstructure';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates the directory structure for CRUDs.';


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

		$p=new PathsInfo();
		$file=new File();
		$continue=false;
		$pathToCrudsControllers=app_path().'/Http/Controllers/cruds';
		$pathToCrudsModels=app_path().'/cruds';
		$templateVendorPath=__DIR__.'/../Generators/templates/scaffold/';

		$this->tryToCreateDir($file, $pathToCrudsControllers);
		$this->tryToCreateDir($file, $pathToCrudsModels);

		$this->info('Copying the BaseCRUD model and controller ...');
		//Copia la clase Base para los modelos de los CRUDS
		$this->tryToCopyFile($file, $templateVendorPath.'BaseCRUDModel.php', $pathToCrudsModels );

		//Copia la clase Base para los controladores de los CRUDS
		$this->tryToCopyFile($file, $templateVendorPath.'BaseCRUDController.php', $pathToCrudsControllers );	

		$this->info('Setting up the namespaces for BaseCRUD classes ...');
		$buffer=str_replace('//SETNAMESPACE', 'namespace', $file->get($pathToCrudsModels.'/BaseCRUDModel.php'));
		$result=$file->put($pathToCrudsModels.'/BaseCRUDModel.php',$buffer);
		$buffer=str_replace('//SETNAMESPACE', 'namespace', $file->get($pathToCrudsControllers.'/BaseCRUDController.php'));
		$result=$file->put($pathToCrudsControllers.'/BaseCRUDController.php',$buffer);
		

		$this->info('Generating the directory structure for working views ...');
		//directorio para las vistas
		$this->tryToCreateDir($file, $p->pathViews().'/cruds');
		$this->tryToCreateDir($file, $p->pathViews().'/system');
		$this->tryToCreateDir($file, $p->pathViews().'/system/cruds');
		$this->tryToCreateDir($file, $p->pathViews().'/layouts');

		$path_config=base_path().'/config/cruds';		
		$this->info('Generating the directory structure for config files at '.$path_config.' ...');
		$this->tryToCreateDir($file, $path_config);

		$this->info('Generating the directory structure for templates ...');
		$path=str_replace('/cruds', '', $p->pathTemplates());
		$this->tryToCreateDir($file, $path);

		$this->tryToCreateDir($file, $p->pathTemplates());
		$this->tryToCreateDir($file, $p->pathTemplatesModel());
		$this->tryToCreateDir($file, $p->pathTemplatesController());
		$this->tryToCreateDir($file, $p->pathTemplatesViews());
		$this->tryToCreateDir($file, $p->pathTemplatesViews().'/master-detail');		
		$this->tryToCreateDir($file, $p->pathTemplatesCustoms());

		
		$this->info('Copying files ...');
		//Copia el template para los modelos
		$templateFileName=$file->name($p->fileModelTemplate()).'.'.$file->extension($p->fileModelTemplate());
		$this->tryToCopyFile($file, $templateVendorPath.$templateFileName, $p->pathTemplatesModel());

		//Copia el template para los controladores
		$templateFileName=$file->name($p->fileControllerTemplate()).'.'.$file->extension($p->fileControllerTemplate());
		$this->tryToCopyFile($file, $templateVendorPath.$templateFileName, $p->pathTemplatesController());

		//Copia los templates de las vistas
		$this->tryToCopyFile($file, $templateVendorPath.'/views/'.$p->fileViewTemplate('create',true), $p->pathTemplatesViews());
		$this->tryToCopyFile($file, $templateVendorPath.'/views/'.$p->fileViewTemplate('edit',true), $p->pathTemplatesViews());
		$this->tryToCopyFile($file, $templateVendorPath.'/views/'.$p->fileViewTemplate('index',true), $p->pathTemplatesViews());
		$this->tryToCopyFile($file, $templateVendorPath.'/views/'.$p->fileViewTemplate('show',true), $p->pathTemplatesViews());

		$this->tryToCopyFile($file, $templateVendorPath.'/views/layouts/example_default.blade.php', $p->pathViews().'/layouts');

		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/header_cruds.php', $p->pathViews().'/system/cruds');
		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/footer_cruds.php', $p->pathViews().'/system/cruds');
		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/header_index_panel.blade.php', $p->pathViews().'/system/cruds');
		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/partial_header_cruds.blade.php', $p->pathViews().'/system/cruds');
		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/second_column_cruds.blade.php', $p->pathViews().'/system/cruds');
		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/partial_notifications.blade.php', $p->pathViews().'/system/cruds');
		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/notifications_layout.blade.php', $p->pathViews().'/system/cruds');
		$this->tryToCopyFile($file, $templateVendorPath.'/views/system/datepicker_loader.blade.php', $p->pathViews().'/system/cruds');		

		$this->tryToCopyFile($file, $templateVendorPath.'/views/master-detail/master_record.template.blade.php', $p->pathTemplatesViews().'/master-detail');		
		$this->tryToCopyFile($file, $templateVendorPath.'/views/master-detail/detail_tables.template.blade.php', $p->pathTemplatesViews().'/master-detail');	
		$this->tryToCopyFile($file, $templateVendorPath.'/views/master-detail/detail_tables_item.template.blade.php', $p->pathTemplatesViews().'/master-detail');

		$this->tryToCopyFile($file, $templateVendorPath.'/config/settings.php', $path_config);

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('resource', InputArgument::REQUIRED, 'El recurso al que se desea definir los nav-tabs.'),
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
			//array('tabdef', null, InputOption::VALUE_REQUIRED, 'Campos indicando tabname:campo campo2 campo3,tabname:campo4, campo5, etc', null),			
		);
	}


	protected function tryToCreateDir($file, $path)
	{
		$this->info('creating '.$path);

		if(!$file->exists($path)){
			if ($this->confirm('The directory does not exist, you want to create? [yes|no]'))
			{
				$file->makeDirectory($path);
				$this->info(' ---> done.');			
			}
		}else{
			$this->info(' ---> this directory already exists, nothing to do.');			
		}
			
	}


	protected function tryToCopyFile($file, $fileToCopy, $path)
	{

		$filename=$file->name($fileToCopy).'.'.$file->extension($fileToCopy);
		$fileTarget=$path.'/'.$filename;

		$this->info('copying '.$filename. ' to '.$path);

		$continue=false;

		if($file->exists($fileTarget)){
			$this->info(' ---> Oops, this file already exists in the target directory.');				
			if ($this->confirm('you want to replace it? [yes|no]'))
			{			
				$continue=true;
				if ($file->lastModified($fileTarget) > $file->lastModified($fileToCopy)){
					$continue=false;
					$this->info(' ---> Warning, the file you are copying is an earlier version, you may lose data if you continue..');				
					if ($this->confirm('we do it? [yes|no]'))
					{
						$continue=true;
					}
				}
			}
		}else{
			$continue=true;
		}

		if($continue){
			//$this->info(" ---Source > $fileToCopy");			
			//$this->info(" ---Target > $fileTarget");			
			if($file->copy($fileToCopy,$fileTarget)){
				$this->info(' ---> done.');			
			}else{
				$this->info(' ---> something is wrong, check if you have write permisions on '.$path);	
				$continue=false;		
			}
		}else{
			$this->info(' ---> nothing was done.');			
		}
		return $continue;
	}

}
