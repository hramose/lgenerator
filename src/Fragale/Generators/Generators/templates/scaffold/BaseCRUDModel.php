<?php //SETNAMESPACE App\cruds;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Input;

class BaseCRUDModel extends Eloquent {

	protected $appends = ['hashid'];

	public function getNextId($id) // deternina el id del proximo registro
	{
		$result=$this->getIdPrevOrNext($id,'>');
		return $result;
	}

	public function getPreviousId($id) // determina el id del registro anterior
	{
		$result=$this->getIdPrevOrNext($id,'<');
		return $result;
	}

	function getMasterModel()
	{
		$result=$this->nvl(ucwords(Input::get('master')),false);
		return $result;
	}	

	function getMasterId()
	{
		return Input::get('master_id');
	}	

	function getMasterField()
	{
		$field='';
		if($this->getMasterModel()){
			$field=strtolower($this->getMasterModel()).'_id';
		}
		return $field;
	}

	public function getIdPrevOrNext($id,$direction) 
	{
		$filtro=$this->filterByMaster();
		if ($direction=='<'){
			$order_direction='desc';
		} else {
			$order_direction='asc';

		}

		$comando="\$findId=static::where('id', '$direction', '$id ')".$this->filterByMaster()."->orderBy('id','$order_direction')->pluck('id');";
		eval($comando);
	    	return $this->nvl($findId,$id);
	}

	public function getIdMaxOrMin($type) 
	{
		$filtro=$this->filterByMaster();
		$table=static::TABLE_NAME;
		$comando="\$findId=DB::table('$table')".$this->filterByMaster()."->$type('id');";
		eval($comando);
	    	return $findId;
	}

	function filterByMaster()
	{
		$filtro='';
		if($this->getMasterModel()){
			$filtro="->where('".$this->getMasterField()."','=','".$this->getMasterId()."')";
		}
		return $filtro;
	}

	function nvl($value,$replace){
		if (empty($value)){
			return $replace;
		}else{
			return $value;
		}		
	}

	public function getHashidAttribute()
	{
		//dump($this->attributes['id']);
    	return \Hashids::encode($this->attributes['id']);
	}
}
