<?php namespace App\Http\Controllers\cruds;

use Illuminate\Filesystem\Filesystem as File;
use App\Http\Controllers\cruds\BaseCRUDController;
use App\cruds\{{Model}};

class {{className}} extends BaseCRUDController {

	/**
	 * {{Model}} Repository  
	 */
	protected ${{model}};
	protected $models_name;
	protected $Model_name;	

	public function __construct({{Model}} ${{model}})
	{
		$this->{{model}}  	= ${{model}};
		$this->models_name 	= '{{models}}';
		$this->Model_name 	= '{{Model}}';		
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
		$formFields = array_except($input, array('master','master_id')); // elimina los parametros master y master_id de los campos a grabar		
		$validation = Validator::make($formFields, {{Model}}::$rules);

		if ($validation->passes())
		{
			$formFields = array_except($formFields, $this->extraFields()); // remueve los campos extra
			$this->{{model}}->create($formFields);

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
		$formFields = array_except($input, array('master','master_id')); // elimina los parametros master y master_id de los campos a grabar
		$validation = Validator::make($formFields, {{Model}}::$rules);

		if ($validation->passes())
		{
			$formFields = array_except($formFields, $this->extraFields());  // remueve los campos extra
			${{model}} = $this->{{model}}->find($id);
			${{model}}->update($formFields);

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
