##### Adding aditional code to models #####


All models are extending the class BaseCRUDModel defined in file `app/cruds/BaseCRUDModel.php`

Also you should append code to your models.

for example to add code to our example model you can do this:

* create a file in `resources/templates/cruds/customs/employees/` named `append_to_model.php`
* put this code into the file: (warning: add the PHP tag at the begin of the file)

```php

	<?php

    public function getFullNameAttribute()
    {
    	return $this->first_name . ' ' . $this->last_name;
    }

```

* now remove the resource
* run the generator again
* check the results into the model `Employee.php`

 **feel free to add your own code in your models**



[home](../readme.md)