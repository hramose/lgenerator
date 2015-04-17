<?php namespace App\Http\Controllers\cruds;

use Illuminate\Filesystem\Filesystem as File;
use App\Http\Controllers\cruds\BaseCRUDController;
use App\cruds\{{Model}};
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class {{className}} extends BaseCRUDController {

	/**
	 * {{Model}} Repository  
	 */
	protected ${{model}};
	protected $models_name;
	protected $Model_name;	
	protected $picture_fields;

	public function __construct({{Model}} ${{model}})
	{
		$this->{{model}}  		= ${{model}};
		$this->models_name 		= '{{models}}';
		$this->Model_name 		= '{{Model}}';	
		$this->picture_fields	= {{pictures}};
		$this->without_validation= array_merge($this->picture_fields, ['master','master_id']);
	}

	/*---------------*/
	public function index()
	{
		$this->setMmasterRecordInfo(); // carga la informacion de un master-record si corresponde

		$this->checkExport(); // verifica si se solicitaron exportaciones de la consulta

		${{models}} = $this->doUserFilter(); // construye la coleccion de datos

		return view('cruds.{{models}}.index', $this->masterRecordArray())->with('{{models}}', ${{models}}); 
	}

	/*---------------*/
	public function create()
	{
		$this->setMmasterRecordInfo();

		return view('cruds.{{models}}.create', $this->masterRecordArray());
	}


	/*---------------*/
	public function show($id)
	{
		${{model}} = $this->{{model}}->findOrFail($id);

		return view('cruds.{{models}}.show', compact('{{model}}'));
	}


	/*---------------*/
	public function edit($id)
	{
		$this->setMmasterRecordInfo();

		${{model}} = $this->{{model}}->find($id);

		if (is_null(${{model}}))
		{
			return Redirect::route('{{models}}.index',$this->masterRecordArray());
		}

		return view('cruds.{{models}}.edit', array_merge(compact('{{model}}'), $this->masterRecordArray() ));		
	}

	/*---------------*/
	public function store()
	{
		$this->setMmasterRecordInfo();

		/*valida todos los campos del formulario*/
		$input = Input::all();
		$formFields = array_except($input, $this->without_validation); // elimina los parametros master y master_id de los campos a grabar		
		$validation = Validator::make($formFields, {{Model}}::$rules);

		if ($validation->passes())
		{
			$formFields = array_except($formFields, $this->extraFields()); // remueve los campos extra
			$this->{{model}}->create($formFields);

			{{move_pictures}}

			return Redirect::route('{{models}}.index', $this->masterRecordArray());
		}

		return Redirect::route('{{models}}.create', $this->masterRecordArray())
			->withInput()
			->withErrors($validation)
			->with('message', trans('forms.validationErrors'));	
	}


	/*---------------*/
	public function update($id)
	{
		$this->setMmasterRecordInfo();

		/*valida todos los campos*/
		$input = array_except(Input::all(), '_method');
		$formFields = array_except($input, $this->without_validation);
		$validation = Validator::make($formFields, {{Model}}::$rules);

		if ($validation->passes())
		{
			$formFields = array_except($formFields, $this->extraFields());  // remueve los campos extra
			${{model}} = $this->{{model}}->find($id);
			${{model}}->update($formFields);

			{{move_pictures}}

			return Redirect::route('{{models}}.show', $this->masterRecordArray($id)  );
		}

		return Redirect::route('{{models}}.edit', $this->masterRecordArray($id) )
			->withInput()
			->withErrors($validation)
			->with('message', trans('forms.validationErrors'));
	}


	/*---------------*/
	public function destroy($id)
	{
		$this->setMmasterRecordInfo();

		$this->{{model}}->find($id)->delete();

		return Redirect::route('{{models}}.index', $this->masterRecordArray());
	}

}
