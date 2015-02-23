<?php
/*Ceres Solutions S.R.L.*/
class {{className}} extends BaseCRUDModel {	

	protected $guarded = array();

	const MODELS 	 = '{{models}}';
	const TABLE_NAME = '{{models}}';	

	public static $rules = array(
							{{rules}}
							);

}
