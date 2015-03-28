<?php namespace App\Http\Controllers\cruds; 

use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class BaseCRUDController extends BaseController {

	protected $Master;
	protected $master_id;

	/**
	 * Genera un string para ser ejecutado con eval() y como resultado
	 * se obtiene un objeto apuntando a la tabla pero con los registros
	 * filtrados uno por uno con el operador LIKE el criterio de busqueda
	 * es la variable de sesion $filter
	 *
	 * @param  string  $filter (str de busqueda introducido por el usuario)
	 * @param  string  $sort (columna para ordenar)
	 * @param  string  $order (ordern desc/asc)
	 * @param  int  $records (se usa para la paginacion)
	 * @return Response
	 */
	//public function doUserFilter($filter,$sort,$order,$records)
	public function doUserFilter()	
	{
		$models_name=$this->models_name;		
		$Model_name="App\cruds\\".$this->Model_name;

		/*orden*/
		$sort=Session::get($models_name.'.sort', "id");
		$order=Session::get($models_name.'.order', "desc");
		$user_sort=trim(Input::get('sort'));
		$user_order=trim(Input::get('order'));
		if($user_sort!=""){
		  Session::put($models_name.'.sort', $user_sort);
		  $sort=$user_sort;
		}
		if($user_order!=""){
		  Session::put($models_name.'.order', $user_order);
		  $order=$user_order;
		}

		/*filtro de usuario*/
		$filter=trim(Session::get($models_name.'.filter', ""));
		$user_filter=trim(Input::get('filter'));
		if($user_filter!=""){
		  if($user_filter=="#reset#"){$user_filter="";}
		  Session::put($models_name.'.filter', $user_filter);
		  $filter=$user_filter;
		}

		/*control de la paginacion*/
		$records= Session::get($models_name.'.records', 25);
		$user_records=Input::get('records');
		if($user_records*1>0 or $user_records*1==-1){
		  $records=$user_records;
		  Session::put($models_name.'.records', $records);
		};		

	    /*filtra*/
	    $whereF="";
	    if ($filter!=""){
	      $fields=$this->getFields();
	      $orPrefix="";
	      foreach ($fields as $field) {
			if ($whereF!=""){$orPrefix="->or";}
			$whereF.="$orPrefix"."where('$field','LIKE','$filter')";
	      } 
	    };

	    /*ordena*/
	    $orderBy="->orderBy('$sort', '$order')";
	    /*registros para la paginacion*/
	    if ($records*1<=0){
	      $paginacion="->paginate(1000);";
	    }else{
	      $paginacion="->paginate(\$records);";
	    }

	   	if ($this->Master!=''){

		    $Master = "App\\cruds\\".$this->Master;
		    $master_id = $this->master_id;	    

	   		if (!class_exists($Master)){
				echo trans('froms.ModelNotFound');
	   		}
	   		if ($Master::find($master_id)){	  
	   			eval('$MasterModel = new '.$Master.';'); 	
	   			$sentencia="\$result = \$MasterModel::find($master_id)->$models_name()->".$whereF.$orderBy.$paginacion;
	   		}else{	   			
	   			$sentencia="\$result = $Model_name::where('id','=','0');";
	   		}	   		
	   	}else{
	   		$sentencia="\$result = $Model_name::".$whereF.$orderBy.$paginacion;	
	   	}

	    /*purifica algunas cagaditas*/
	    $sentencia=str_replace('::->', '::', $sentencia);
	    $sentencia=str_replace('->->', '->', $sentencia);

	    /*arna la coleccion de datos*/ 
	    eval($sentencia);
	    return $result;
	}

	/**
	 * Devuelve un array con los nombres de las columnas.
	 *
	 * @return array
	 */
	public function getFields()
	{
		$models_name=$this->models_name;

	    $field_names = array();
	    $disallowed = array('id', 'created_at', 'updated_at', 'deleted_at');

	    $columns = DB::select('SHOW COLUMNS FROM '.$models_name);
	    foreach ($columns as $c) {
		$field = $c->Field;
		if ( ! in_array($field, $disallowed)) {
		    $field_names[$field] = $field;
		}
	    }

	    return $field_names;
	}

    /**
     * Verifica si hay campos que no pertenecen al modelo y que son "extra"
     *
     * @return array
     */
    public function extraFields()
    {
        $models_name=$this->models_name;
        
        $extra = array();

        $path=app_path()."/views/$models_name/customs/formfields_layout.php";
        if (file_exists($path))
        {
            $file=new File();
            $extraFields = json_decode($file->get($path), true);
            $key='fields_extra';
            if (array_key_exists($key, $extraFields)) {
              $extra=explode(',',$extraFields[$key]);
            }
        }        
        return $extra;
    } 	

	/**
	* Exporta el contenido de la tabla en formato Excel
	* aplica los filtros y la paginacion que hereda del grid del index
	*
	* @param  string  $tipo (Excel2007 / Excel5)
	* @return string
	*/

	public function doExport($tipo)
	{   
	    $models_name=$this->models_name; 
	    //$model_name=$this->model_name; 


		/*orden*/
		$sort=Session::get($models_name.'.sort', "id");
		$order=Session::get($models_name.'.order', "desc");

		/*filtro de usuario*/
		$filter=trim(Session::get($models_name.'.filter', ""));

		/*control de la paginacion*/
		$records= Session::get($models_name.'.records', 25);

		/*construye el objeto*/
		$registros = $this->doUserFilter($filter,$sort,$order,$records);
		$fields = $this->getFields();

		// Crea un nuevo objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Propiedades del documento
		$tabla="$models_name";
		$creator = Config::get('kyron.titulo');
		$lastModifiedBy=$creator;
		$title=trans('forms.exportOfTable').' '.$tabla;
		$subject=$title;
		$description=$title.", ".Config::get('kyron.descripcion');
		$category=trans('forms.export');
		$keywords="$category $tabla Kyron";
		$efont=Config::get('kyron.font');
		$epath=Config::get('kyron.pathexport');

		$objPHPExcel->getProperties()
					->setCreator($creator)
					->setLastModifiedBy($lastModifiedBy)
					->setTitle($title)
					->setSubject($subject)
					->setDescription($description)
					->setKeywords($keywords)
					->setCategory($category);

		// Pone los titulos
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(18);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName($efont);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $title);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName($efont);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(false);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $creator);

		// Pone el nombre de la hoja
		$objPHPExcel->getActiveSheet()->setTitle($tabla);

		// Pone los titulos de las columnas
		$fila=5;
		$columna="A";
		foreach ($fields as $field) {
			$celda=$columna.trim($fila);
			$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(14);
			$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setName($efont);
			$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($celda, ucwords($field));
			$columna++;
		}

		foreach ($registros as $registro) {
			$fila++;
			$columna="A";
			foreach ($fields as $field) {
				$celda=$columna.trim($fila);
				eval("\$valor=\"\$registro->$field\";");
				$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(14);
				$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setName($efont);
				$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setBold(false);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($celda, $valor);
				$columna++;
			}
		}

		//Nombre del archivo
		$nombre_archivo=$epath."$models_name".date("Ymdhis");

		switch ($tipo){
			case "Excel5":
				$extension=".xls";
				break;
			//case "PDF":
			case "Excel2007":
			default:
				$extension=".xlsx";	 
		}
		$nombre_archivo.=$extension;

		//Construye el archivo
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $tipo);
		$objWriter->save(public_path()."/".$nombre_archivo);

		return $nombre_archivo;
	}

	public function checkExport()
	{
		/*exportaciones*/
		$mensaje="";
		$tipo=trim(Input::get('exportar'));
		if ($tipo) {
			$archivo=$this->doExport($tipo);
			$mensaje=trans('forms.exportOK');
			Session::put('exportacionok', $mensaje);
			Session::put('exportacionfile', $archivo);
			$hayExportacion=true;			
		} else {
			Session::forget('exportacionok');
			Session::forget('exportacionfile');
			$hayExportacion=false;
		}

		return $hayExportacion;
	}

	public function masterRecordArray($id='')
	{
		
		$result=array('master'=>$this->Master, 'master_id' => $this->master_id);

		if($id){
			$result=array_merge(array('id' => $id), $result);
		}

		return $result;
	}

	public function setMmasterRecordInfo()
	{
		$master 	= Input::get('master');
		$master_id 	= Input::get('master_id');		

		/*verifica si hay un masterrecord*/
		$this->Master=ucwords(trim($master));
		$this->master_id=$master_id;
		return true;
	}

}
