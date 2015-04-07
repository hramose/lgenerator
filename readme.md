This Laravel 5 package provides a fully customizable CRUDs generators to speed up your development process. These generators include:

 - `makefast:crudstructure`
 - `makefast:scaffold`
 - `makefast:navtab`
 - `makefast:remove`

## 
This is a derivative of the original version of J. Way, this includes the adaptation specifically for the generation of scaffolds.

If you are looking for a "generic" generator is recommended to use way/generators

## Installation

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

## Requirements

IMPORTANT !!!
*** This package requires Twitter Bootstrap 3 ***
If your project still is not using Twitter Bootstrap 3 (TWBS), do not worry, the package includes the dependence necessary for Bootstrap is downloaded to your project.
In this case after run *** composer update ** just make this to create an asset entry for TWBS in your /public directory:

in the console:

LINUX

```bash
cd YOUR_INSTALATION_PATH (where is your composer.json)
mkdir public/assets/plugins
mkdir public/assets/plugins/bootstrap
cd public/assets/plugins/bootstrap/
ln -s ../../../../vendor/twbs/bootstrap/dist ./bootstrap
```

WIN

```bash
create a directory into YOUR_INSTALATION_PATH/public/assets/plugins/bootstrap/bootstrap
after
copy the entire dir: YOUR_INSTALATION_PATH/vendor/twbs/bootstrap/dist into YOUR_INSTALATION_PATH/public/assets/plugins/bootstrap/bootstrap
```

then you may see:

```

	YOUR_INSTALATION_PATH/
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

(for more info and docs see https://github.com/twbs/bootstrap)


## Usage

You may think about the CRUDs generator as a tool to help you to make shorter implementation times, it is also useful to accelerate refactoring time of all CRUDs included in your app.

- [Crud Structure](#crudstructure)
- [Scaffolding](#scaffolding)
- [Nav Tabs](#navtabs)
- [Remove](#remove)

### Crud Structure

After installation, the first thing you have to do is generate the structure of work for the CRUDs generator .

```bash
    php artisan makefast:crudstructure
```

This command will create a directory structure into your `/application_instalation` directory

After this creation, the artisan will copy a serie of templates into 

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


### Scaffolding


The scaffolding is an skeleton for a serie of classes relatives to a resourse

```bash
php artisan makefast:scaffold tweet --fields="author:string, body:text"
```

Note that the generator works on a existing table, then you must create the migration first if the table not exist.


```

Nice! A few things to notice here:

- The controller for the object is created in app/Http/cruds
- The model for the object is created in app/cruds
- The generator will automatically create the views for this object in app/resources/views/cruds
- The templates for the controller, model and views, are located in app/resources/templates/cruds
- The generator will automatically asume the `id` as the primary key.

To declare fields, use a comma-separated list of key:value:option sets, where `key` is the name of the field, `value` is the [column type](http://four.laravel.com/docs/schema#adding-columns), and `option` is a way to specify indexes and such, like `unique` or `nullable`. Here are some examples:

- `--fields="first:string, last:string"`
- `--fields="age:integer, yob:date"`
- `--fields="username:string:unique, age:integer:nullable"`
- `--fields="name:string:default('John'), email:string:unique:nullable"`
- `--fields="username:string[30]:unique, age:integer:nullable"`

```


#### Scaffolding models

##### Adding aditional code
All models are extending the class BaseCRUDModel defined in file `/app/cruds/BaseCRUDModel.php`

Also you should append code to your models:
for this you may create a file in `/app/resources/templates/cruds/customs/OBJECTNAME/append_to_model.php`

the code included in this file will be appended to the model for the OBJECTNAME.

##### Adding rules

You can add customized rules to your model validation simply adding code into `/app/resources/templates/cruds/customs/OBJECTNAME/rules.php`


##### Customizing the views generation


You must customize the view generation for your model, just adding a .json file in `/app/resources/templates/cruds/customs/OBJECTNAME/views_definition.json`

the file structure is:

```
{
	"description": "Employee slave records",
    "field_definitions": 
	    {
	      "_comment":"indicar los campos no se deben generar en los formularios",
	      "index_disallowed":"user_id,from_issue_id",
	      "edit_disallowed":"user_id,from_issue_id",
	      "create_disallowed":"id,user_id,from_issue_id",
	      "show_disallowed":"id,user_id,from_issue_id",
	      "_comment":"indicar los campos que son de solo lectura",
	      "edit_readonly":"id",
	      "_comment":"campos con formato especial en index y en show",
	      "id_format":"#%d",
	      "fields_extra":"somefield"
	    }
	,
    "customized_fields": 
	    {
	      "type":"{{ Form::select('type', array('bug'=>'Bug', 'function'=>'Funcionalidad','develop'=>'Desarrollo'), {{value}}, array('class' => 'form-control')) }}",
	      "status":"{{ Form::select('status', array('open'=>'Open', 'solved'=>'Solved','closed'=>'Closed','closed_unsolved'=>'Closed_Unsolved'), {{value}}, array('class' => 'form-control')) }}"
	    }
    ,
    "detail_records": [
        {
            "description": "Families table",
            "model": "families"
        }
    ]
}

```

I am writing the documentation... please be patient



PLEASE NOTE THAT I AM CURRENTLY DEVELOPING THIS PACKAGE.
THE TIME THAT I'M DEDICATING THIS PROJECT IS CONDITIONED BY MY DAILY DUTIES, IF YOU WANT, YOU CAN CONTACT ME IN fragale@gmail.com

DAILY I WILL UPLOAD NEW FEATURES,

ACTUALLY THE PACKAGE IS NOT STABLE YET
