##### Hide a field in a view #####

i.e:
To show only **first_name, last_name** fields in the **index view** you must do the following:

* just add:...

```

	{
		"description": "Families",
	    "field_definitions": 
		    {
		      "index_disallowed":"gender, employee_id, date_of_birth, nacionality, city_of_birth, marital_status, document_type, document_number, passport_number, ss_number,photo",
		      "edit_disallowed":"",
		      "create_disallowed":"",
		      "show_disallowed":"",
		      "edit_readonly":""
		    }
	
	.... (here the rest of definitions)

	}

```

* now run this:

```bash

	php artisan makefast:remove families --auto --dirs
	php artisan makefast:scaffold families --fields="first_name:string(64),last_name:string(64), gender:custom, employee_id:master, date_of_birth:date, nacionality:string(64), city_of_birth:string(64), marital_status:string(3), document_type:string(3), document_number:string(20), passport_number:string(20), ss_number:string(20),photo:picture(200x200)"

```

* now check the results in your browser.

[home](../readme.md)