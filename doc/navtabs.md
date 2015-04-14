##### Grouping fields in navs #####

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


[home](../readme.md)