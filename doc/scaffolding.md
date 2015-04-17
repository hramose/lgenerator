### Scaffolding ###


The scaffolding is an skeleton for a serie of classes related to an resource, for our example the resource is the `employees` table

then try to generate the CRUDs for the employees table, advance slowly, we use only some fields for now.

Run this command:

```bash
php artisan makefast:scaffold employees --fields="first_name:string(64), last_name:string(64), gender:string(1)"
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

**¿troubles?**
probably you are getting an error message at this point.
This occurs because the views are using a layout (you might change this later), but if you do not have a defined layout 
use the example provided whith this package, simply rename `resources/views/layouts/example_default.blade.php` to `resources/views/layouts/default.blade.php`

*or maybe you preffer create one using this as an example:*

* create a file in `resources/views/layouts` with the name `default.blade.php`
* copy and paste this code into the file:

```php

		<!DOCTYPE html>
		<html lang="en">
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"> 
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
		    <body>		
				<div id="page-container">
					<div class="container-fluid">
						<div class="row">
						  	@if($lc->config('col_1_visible'))
						  	<div class="{{$lc->config('col_full')}}">
								@yield('content')
							</div> 
							@endif		
						</div>
					</div>			
				</div>
			<script src="{{ asset('assets/plugins/jquery/jquery/jquery.min.js') }}"></script>
			<script src="{{ asset('assets/plugins/bootstrap/bootstrap/js/bootstrap.min.js') }}"></script>
			<script src="{{ asset('assets/plugins/bootstrap/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
			<script src="{{ asset('assets/plugins/bootstrap/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
			@include('system.cruds.scripts_loader') 

			</body>	
		</html>
```

6. save and try again going to http://www.yourapp.com/employees  

*IMPORTANT if are having troubles with Bootstrap?* [Check your Bootstrap installation](doc/checkbootstrap.md)  



[home](../readme.md)