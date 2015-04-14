##### Hide a field in a view #####

i.e:
To hide the `employee_id` field in the **index view** you must do the following:

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
	}

```

* now run this:

```bash

	php artisan makefast:remove families --auto --dirs
	php artisan makefast:scaffold families --fields="first_name:string(64), last_name:string(64), employee_id:master"	

```

* now check the results in your browser.



[home](../readme.md)