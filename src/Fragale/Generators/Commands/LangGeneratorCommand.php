<?php namespace Fragale\Generators\Commands;
/*
Modo de usarlo

php artisan command:lang file phrase --tr="es:Palabra,en:Word,it:Parola"

*/
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem as File;

class LangGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'crud:lang';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Traduce palabras dentro de los archivos de idioma.';

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
		$lang_file=new File();
		$file = $this->argument('file');
		$phrase= $this->argument('phrase');
		$tr=$this->option('tr');

		$phrases = preg_split('/, ?/', $tr);
		foreach($phrases as $pair)
		{
			list($lang, $traduction) = preg_split('/ ?: ?/', $pair);
			$this->info("traducion para '$phrase' en idioma '$lang' = '$traduction'");
			$path=base_path()."/resources/lang/$lang/$file".".php";
			$this->info("...archivo de idioma utilizado: $path.");
			if(!$lang_file->exists($path)){
				$this->info("ADVERTENCIA: el archivo de idioma no existe, deberas crearlo manualmente.");
			}else{
				$buffer=$lang_file->get($path);
				$element="'$phrase' => '$traduction', ";
				$buffer=str_replace(");", $element.PHP_EOL.");", $buffer);
				if($lang_file->put($path,$buffer)){
					$this->info("........hecho");
				}else{
					$this->error("........algo salio mal");
				}
			}
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
			array('file', InputArgument::REQUIRED, 'El archivo de idioma, por ej para forms.php utilizar forms.'),
			array('phrase', InputArgument::REQUIRED, 'La palabra o frase que se desea traducir.'),
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
			array('tr', null, InputOption::VALUE_OPTIONAL, 'Traduccion.', null),
		);
	}

}
