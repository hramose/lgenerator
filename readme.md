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

This command will create a directory structure into your `/app` directory

After this creation, the artisan will copy a serie of templates into `/app/resourses/templates`

If we don't specify the `fields` option, the following file will be created within `app/database/migrations`.




### Scaffolding


The scaffolding is an skeleton for a serie of classes relatives to a resourse

```bash
php artisan makefast:scaffold tweet --fields="author:string, body:text"
```

The only difference is that it will handle all of the boilerplate. This can be particularly useful for prototyping - or even learning how to do basic things, such as delete a record from a database table, or build a form, or perform validation on that form.


```

Nice! A few things to notice here:

- The generator will automatically set the `id` as the primary key.
- It also will add the timestamps, as that's more common than not.
- It parsed the `fields` options, and added those fields.
- The drop method is smart enough to realize that, in reverse, the table should be dropped entirely.

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








PLEASE NOTE THAT I AM CURRENTLY DEVELOPING THIS PACKAGE.
THE TIME THAT I'M DEDICATING THIS PROJECT IS CONDITIONED BY MY DAILY DUTIES, IF YOU WANT, YOU CAN CONTACT ME IN fragale@gmail.com

DAILY I WILL UPLOAD NEW FEATURES,

ACTUALLY THE PACKAGE IS NOT STABLE YET
