#### Checking Bootstrap installation ####

To check if Bootstrap are running ok, first [Enable Bootstrap 3.0 ](doc/bootstrap.md), then put this in your routes.php:

```php

	Route::get('testbootstrap', function()
	{
	    return view('layouts.checkbootstrap');
	});
```php

* save and try it going to http://www.yourapp.com/testbootstrap 

if you have Bootstrap running, then will see a 
![Correct Button](doc/correct_button.png)


if you have Bootstrap wrong, then will see:
![Inorrect Button](doc/incorrect_button.png)



[home](../readme.md)