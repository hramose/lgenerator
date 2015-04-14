##### Adding rules #####


The rules for the field validation are defined in the model file at `app/cruds/Employee.php` (for our example resource)

Also you should add your own validation rules.

for example you can do this:

* create a file in `resources/templates/cruds/customs/employees/` named `rules.php`
* put this code into the file: (warning: add the PHP tag at the begin of the file)

```php

	<?php

	public static $rules = array(
							
		'first_name' => 'required',
		'last_name' => 'required',
		'gender' => 'required'

```

* now remove the resource
* run the generator again
* check the results into the model `Employee.php`

 **feel free to add your own rules in your models**



[home](../readme.md)