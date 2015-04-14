##### Grouping fields in navs #####

* To add [navs](http://getbootstrap.com/components/#nav) in the families views just modify the file: `resources/templates/cruds/customs/families/views_definitions.json`

```php

	{
		"description": "Families",
	    "field_definitions": 
		    {
		      "_comment":"indicar los campos no se deben generar en los formularios",
		      "index_disallowed":"employee_id",
		      "edit_disallowed":"",
		      "create_disallowed":"",
		      "show_disallowed":"",
		      "_comment":"indicar los campos que son de solo lectura",
		      "edit_readonly":"",
		      "_comment":"campos con formato especial en index y en show",
		      "id_format":"#%d"
		    }
		,
	    "customized_fields": 
		    {
		      "gender":"{!! $lc->radio('gender',['f' => 'Female','m' => 'Male'], (isset($family->gender)) ? $family->gender : '' ) !!}"
		    },
		"navtab_definitions":
		    {
		    	"general":["first_name", "last_name", "gender", "employee_id"],
		    	"personal":["date_of_birth", "nacionality", "city_of_birth", "marital_status"],
		    	"identifications":["document_type", "document_number", "passport_number", "ss_number"]
			}
	}

```

* now run this:

```bash

	php artisan makefast:remove families --auto --dirs
	php artisan makefast:scaffold families --fields="first_name:string(64),last_name:string(64), gender:custom, employee_id:master, date_of_birth:date, nacionality:string(64), city_of_birth:string(48), marital_status:string(3), document_type:string(3), document_number:string(20), passport_number:string(20), ss_number:string(20)"
```

* finally, check the results in your browser!!.


[home](../readme.md)