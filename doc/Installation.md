Installation
============


Begin by installing this package through Composer. Edit your project's `composer.json` file to require `fragale/lgenerators`.

	"require": {
		"laravel/framework": "5.0.*",
		"fragale/lgenerators": "1.0.*@dev"
	},
	"minimum-stability" : "dev"

* Next, update Composer from the Terminal:

    composer update

* Once this operation completes, the final step is to add the service provider. Open `config/app.php`, and add a new item to the providers array.

```php

    'Fragale\Generators\GeneratorsServiceProvider',
    'Collective\Html\HtmlServiceProvider',     			/*<- Laravel Collective*/
```    

and add the aliases for Laravel Collective

```php

		'Form' => 'Collective\Html\FormFacade',
		'Html' => 'Collective\Html\HtmlFacade',	
```		

* That's it! You're all set to go. Run the `artisan` command from the Terminal to see the new `makefast` commands.

    php artisan

Note that the package use psr-4

[home](../readme.md)