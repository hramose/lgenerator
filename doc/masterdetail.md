#### Master-detail generation ####

Master-detail presentations allow you to navigate a webpage based on a specific table, and at the same time for each selected record (master record) see the associated records from other related tables (details). 

please let me continue with our example resource `employees`

imagine now that the employees have family (his childrens, parents, brothers, etc.) and they are represented by the table families

to continue learning how to generate this feature, please make this migration:

* create a file into `database/migrations` called `2015_04_01_000000_create_families_table.php`

* copy and paste this code: (warning: add the php tag at the begin of the file)

```php

	<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateFamiliesTable extends Migration {

		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('families', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('first_name');
				$table->string('last_name');
				$table->enum('gender', ['f', 'm']);

				$table->date('date_of_birth');
				$table->string('nacionality',3);
				$table->string('city_of_birth');

				$table->string('marital_status');			

				$table->string('document_type');
				$table->string('document_number');
				$table->string('passport_number')->nullable();
				$table->string('ss_number');

				//Employees link
				$table->integer('employee_id')->unsigned()->nullable();

				$table->timestamps();

				$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::drop('families');
		}
	}

```

* run the migration

```bash
php artisan migrate
```

Now you have two tables, employees and families.

As you can see, families are related with employees table by the `employee_id` field, then you need to add the relationship at the model


continue ...

* modify the file `resources/templates/cruds/customs/employees/append_to_model.php`
* copy and paste this code :

```php

	<?php

	// the relationship with families table 
	public function families()
	{
		return $this->hasMany('App\cruds\Family');
	}

	// the above example
    public function getFullNameAttribute()
    {
    	return $this->first_name . ' ' . $this->last_name;
    }	

```
With the above, the relation from employees-families are created, now we need to create the relation families-employees

* create a file in `resources/templates/cruds/customs/families/` named `append_to_model.php`
* put this code into the file: 

```php

	<?php

	// the relationship with employees table 
	public function employee()
	{
		return $this->belogsTo('App\cruds\Employee');
	}

```

* create a `.json` file in `resources/templates/cruds/customs/employees/` named `views_definitions.json`
* put this code into the file: 

```php

	{
		"description": "Employees table views definitions",
	    "detail_tables": [
	        {
	            "description": "Families table",
	            "model": "families"
	        }
	    ]    ,
	    "master_record_field": [
	        {
	            "display": "$lc->master_record->fullname"
	        }
	    ]
	}

```

* now remove the resource employes end re-generate it

```bash

	php artisan makefast:remove employees --auto --dirs
	php artisan makefast:scaffold employees --fields="first_name:string(64), last_name:string(64), gender:string(1)"
```

* generate the families CRUD

```bash

	php artisan makefast:scaffold families --fields="first_name:string(64), last_name:string(64), employee_id:master"	
```

* check the results into the models `Employee.php` and `Family.php`

* also two new files are created, you can check it on:

```

	application_instalation/	
	├── ...
	└── resources/
		├── ...
		└── views/					
			├── ...		
			└── cruds/
				├── ...
				└── employees/		
					├── master-detail/						
					│	├── employees_detail_tables.blade.php 
					│	└── employees_master_records.blade.php 
					└── ... 

```


###### To view the results at the browser ######

* create some records in the employees table
* go to show view
* open the families relation link

[home](../readme.md)