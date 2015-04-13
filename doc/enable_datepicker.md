## Enabling Datepicker and jquery access ##

If you want to add a datepicker control to your's cruds, first must add a asset in your `public/` directory.

If you are using LINUX

* make the access to bootstrap-datepicker
```bash
cd application_instalation/ (**where is your composer.json**)
cd public/assets/plugins/bootstrap/
ln -s ../../../../components/bootstrap-datepicker ./bootstrap-datepicker
```

* make the access to jquery
```bash
cd application_instalation/ (**where is your composer.json**)

mkdir public/assets/plugins/jquery
cd public/assets/plugins/jquery	
ln -s ../../../../components/jquery ./jquery
```

If you are using WIN (my condolences!!!)

* just copy the entire directories `components/bootstrap-datepiker` into `public/assets/plugins/bootstrap`
* just copy the entire directories `components/jquery` into `public/assets/plugins/jquery`



then you may see:

```

	application_instalation/
	├── ...	
	└── public/
		└── assets/
			└── plugins/
				├── ...							
				├── bootstrap-/
				│	├── ...					
				│	└── bootstrap-datepicker/
				└── jqyery/
					└── jqyery/				

```

After create de access to bootstrap-datepicker and jquery you must add the links into your blade-template (see example_default.blade.php )

* open the file `resources/views/layouts/default.blade.php`
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
				@include('system.cruds.datepicker_loader')
			</body>	
		</html>
```

it's all.

[home](../readme.md)