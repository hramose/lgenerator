This Laravel 5 package provides a fully customizable CRUDs generators to speed up your development process. These generators include:

 - `makefast:crudstructure`
 - `makefast:scaffold`
 - `makefast:navtab`
 - `makefast:remove`

## 
This is a derivative of the original version of J. Way, this includes the adaptation specifically for the generation of scaffolds.

If you are looking for a "generic" generator is recommended to use way/generators

## Installation ##

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `fragale/lgenerators`.

	"require": {
		"laravel/framework": "5.0.*",
		"fragale/lgenerators": "1.0.*"
	},
	"minimum-stability" : "dev"

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Fragale\Generators\GeneratorsServiceProvider'

That's it! You're all set to go. Run the `artisan` command from the Terminal to see the new `makefast` commands.

    php artisan

Note that the package use psr-4

## Requirements ##

IMPORTANT !!!
**This package requires Twitter Bootstrap 3**
If your project still is not using Twitter Bootstrap 3 (TWBS), do not worry, the package includes the dependence necessary for Bootstrap is downloaded to your project.
In this case after run *** composer update ** just make this to create an asset entry for TWBS in your /public directory:

in the console:

LINUX

```bash
cd application_instalation/ (**where is your composer.json**)
mkdir public/assets/plugins
mkdir public/assets/plugins/bootstrap
cd public/assets/plugins/bootstrap/
ln -s ../../../../vendor/twbs/bootstrap/dist ./bootstrap
```

WIN

```bash
create a directory into `application_instalation/public/assets/plugins/bootstrap/bootstrap`
after
copy the entire dir: `application_instalation/vendor/twbs/bootstrap/dist` into `application_instalation/public/assets/plugins/bootstrap/bootstrap`
```

then you may see:

```

	application_instalation/
	├── ...	
	└── public/
		└── assets/
			└── plugins/
				└── bootstrap/
					└── bootstrap/
						├── css/
						│   ├── bootstrap.css
						│   ├── bootstrap.css.map
						│   ├── bootstrap.min.css
						│   ├── bootstrap-theme.css
						│   ├── bootstrap-theme.css.map
						│   └── bootstrap-theme.min.css
						├── js/
						│   ├── bootstrap.js
						│   └── bootstrap.min.js
						└── fonts/
						    ├── glyphicons-halflings-regular.eot
						    ├── glyphicons-halflings-regular.svg
						    ├── glyphicons-halflings-regular.ttf
						    ├── glyphicons-halflings-regular.woff
						    └── glyphicons-halflings-regular.woff2             		 		   			  
```

(*for more info and docs see https://github.com/twbs/bootstrap*)



### Crud Structure ###

After installation, the first thing you have to do is generate the structure of work for the CRUDs generator .

```bash
    php artisan makefast:crudstructure
```

This command will create a directory structure into your `/application_instalation` directory

After this creation, the artisan will copy a serie of templates into 

```

	application_instalation/	
	├── app/
	│	├── ...											
	│	├── Http/
	│	│	└── Controllers/
	│	│	    ├── ...
	│	│		└── cruds/
	│	│	   	  	└── BaseCRUDController.php
	│	├── ...
	│	└── cruds/
	│	  	└── BaseCRUDModel.php
	├── ...
	└── resources/
		├── ...
		├── templates/
		│	└── cruds/
		│		├── controller/
		│		│   └── controller.template.blade.php
		│		├── customs/
		│		├── model/
		│		│   └── model.template.blade.php
		│		└── views/
		│			├── master-detail/
		│			│   ├── detail_tables.template.blade.php
		│			│   ├── detail_tables_item.template.blade.php
		│			│   └── master_record.template.blade.php
		│			├── create.template.blade.php 
		│			├── edit.template.blade.php
		│			├── show.template.blade.php
		│			└── create.template.blade.php
		└── views/					
			├── ...		
			├── cruds/			
			└── system/
				├── ...			
				└── cruds/
					├── header_cruds.php 
					├── footer_cruds.php
					├── header_index_panel.blade.php
					├── partial_header_cruds.blade.php					
					└── second_column_cruds.blade.php				
```

## Usage ###

Of course, to have a CRUD, you should have a table in the database.

Do you have one?
does not?
Then you can create this as an example to learn how to use the generator, of course you can try your own tables.

Just begin:

* create a file into `database/migrarions` called `2015_04_01_000000_create_employees_table.php`

* copy and paste this code: (warning: add the php tag at the begin of the file)

```

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
		public function up()
		{
			Schema::create('employees', function(Blueprint $table)
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

				$table->string('country_of_residence',3);
				$table->string('city_of_residence');
				$table->string('street_address');
				$table->string('street_number');
				$table->string('phone_number')->nullable();
				$table->string('celular_number')->nullable();
				$table->string('email_adress')->nullable();	

				$table->timestamps();
	
			});
		}

		/**
	 	* Reverse the migrations.
	 	*
	 	* @return void
	 	*/
		public function down()
		{
			Schema::drop('employees');
		}
	}

```

* run the migration

```bash
php artisan migrate
```

* you are ready to try... let's go

### Scaffolding ###


The scaffolding is an skeleton for a serie of classes related to an resource, for our example the resource is the `employees` table

then try to generate the CRUDs for the employees table, advance slowly, we use only some fields for now.

Run this command:

```bash
php artisan makefast:scaffold employees --fields="first_name:string[64], last_name:string[64], gender:string[64]"
```


after this, check what happened:


The generator will be created some files and structures
1. the controller
2. the model
3. the CRUD views

```
	application_instalation/	
	├── app/
	│	├── ...											
	│	├── Http/
	│	│	└── Controllers/
	│	│	    ├── ...
	│	│		└── cruds/
	│	│			├── ...
	│	│	   	  	└── EmployeesController.php  (1)
	│	├── ...
	│	└── cruds/
	│		├── ...
	│	  	└── Employee.php  (2)
	├── ...
	└── resources/
		├── ...
		└── views/					
			├── ...		
			└── cruds/
				├── ...
				└── employees/			(3)			
					├── create.blade.php 
					├── edit.blade.php 
					├── index.blade.php 
					└── show.blade.php 

```

4. also the `routes.php` will be modified adding the route to the new resource.


5. now you can check the results on the browser going to http://www.yourapp.com/employees  

¿troubles?
probably you are getting an error message at this point.
This occurs because the views are using a layout (you might change this later), but if you do not have a defined layout might use this as an example:

* create a file in `resources/views/layouts` with the name `default.blade.php`
* copy and paste this code into the file:

```

		<!DOCTYPE html>
		<html lang="en">
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"> 
		    <body>		
				<div id="page-container">
					<div class="container-fluid">
						<div class="row">
						  	@if(isset($col_1_visible))
						  	<div class="{{$col_full}}">
								@yield('content')
							</div> 
							@endif		
						</div>
					</div>			
				</div>
				<script src="{{ asset('assets/plugins/bootstrap/bootstrap/js/bootstrap.min.js') }}"></script>
			</body>	
		</html>
```

6. save and try again going to http://www.yourapp.com/employees  



#### Removing a resource ####

To remove a resource, simply run `makefast:remove`

for example to remove the employees from your proyect just run:

```bash
php artisan makefast:remove employees --auto --dirs
```


##### Adding aditional code #####


All models are extending the class BaseCRUDModel defined in file `app/cruds/BaseCRUDModel.php`

Also you should append code to your models.

for example to add code to our example model you can do this:

* create a file in `/app/resources/templates/cruds/customs/employees/` named `append_to_model.php`
* put this code into the file: (warning: add the PHP tag at the begin of the file)

```

    public function getFullNameAttribute()
    {
    	return $this->first_name . ' ' . $this->last_name;
    }

```

* now remove the resource
* run the generator again
* check the results into the model `Employee.php`

 **feel free to add your own code in your models**



##### Adding rules #####


The rules for the field validation are defined in the model file at `app/cruds/Employee.php` (for our example resource)

Also you should add your own validation rules.

for example you can do this:

* create a file in `/app/resources/templates/cruds/customs/employees/` named `rules.php`
* put this code into the file: (warning: add the PHP tag at the begin of the file)

```

	public static $rules = array(
							
		'first_name' => 'required',
		'last_name' => 'required',
		'gender' => 'required'

```

* now remove the resource
* run the generator again
* check the results into the model `Employee.php`

 **feel free to add your own rules in your models**


#### Customizing the views generation ####


the documentation is comming soon...


#### Excel and OpenOffice exportation ####


the documentation is comming soon...


#### PDF reports generation ####


the documentation is comming soon...


#### Note ####


I am writing the documentation... please be patient



PLEASE NOTE THAT I AM CURRENTLY DEVELOPING THIS PACKAGE.
THE TIME THAT I'M DEDICATING THIS PROJECT IS CONDITIONED BY MY DAILY DUTIES, IF YOU WANT, YOU CAN CONTACT ME IN fragale@gmail.com

DAILY I WILL UPLOAD NEW FEATURES,

ACTUALLY THE PACKAGE IS NOT STABLE YET
