###### Radio buttons ######

Add a radio buttons group to manage the 'gender' field

* just add:...

```

	{
		"description": "Families",
	    "field_definitions": 
		    {
		      "index_disallowed":"employee_id",
		      "edit_disallowed":"",
		      "create_disallowed":"",
		      "show_disallowed":"",
		      "edit_readonly":""
		    }
		,
	    "customized_fields": 
		    {
		      "gender":"{!! $lc->radio('gender',['f' => 'Female','m' => 'Male'], (isset($family->gender)) ? $family->gender : '' ) !!}"
		    }    
	}

```

* now run this:

```bash

	php artisan makefast:remove families --auto --dirs
	php artisan makefast:scaffold families --fields="first_name:string(64), last_name:string(64), employee_id:master, gender:custom"	

```

* now check the results in your browser!!.






[home](../readme.md)