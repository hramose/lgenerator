<?php namespace App\cruds;

use App\cruds\BaseCRUDModel;

class {{className}} extends BaseCRUDModel {	

	/* The database table
	*/
	protected $table = '{{models}}';

	
	protected $guarded = array();


	const MODELS 	 = '{{models}}';
	const TABLE_NAME = '{{models}}';	

	/* The validation rules 
	*/
	public static $rules = array(
							{{rules}}
							);

	{{append_to_model}}

}
