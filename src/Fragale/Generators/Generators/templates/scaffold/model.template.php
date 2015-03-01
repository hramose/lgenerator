<?php namespace App\cruds;

use App\cruds\BaseCRUDModel;

class {{className}} extends BaseCRUDModel {	

	protected $guarded = array();

	const MODELS 	 = '{{models}}';
	const TABLE_NAME = '{{models}}';	

	public static $rules = array(
							{{rules}}
							);

}
