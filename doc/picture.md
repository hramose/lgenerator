#### Picture fields ####

The picture fields can be used to uploads photos or images to a table.

i.e:
To add a field "photo" to families CRUD,
you can use `photo:picture(200x200)`
it means:
a field named `photo`, of type `picture`, with dimentions `width 200` and `height 200`


at the console:

```bash

	php artisan makefast:remove families --auto --dirs
	php artisan makefast:scaffold families --fields="first_name:string(64),last_name:string(64), gender:custom, employee_id:master, date_of_birth:date, nacionality:string(64), city_of_birth:string(64), marital_status:string(3), document_type:string(3), document_number:string(20), passport_number:string(20), ss_number:string(20),photo:picture(200x200)"


```

Of course, also you can modify same preferences for your picture fields at `settings.php`

```php

	/*--------------------------------------------------------------------------
	| Picture & image classes
	|---------------------------------------------------------------------------
	| 	
	*/	
	'picture_class' =>"img-rounded",
	'pictures_path' =>"uploads/pictures",
```

Note that the path is the location `uploads/pictures` where the pictures will be moved after upload it, and it's path is relative to `public/` and it **must be writable**

The 'picture_class' can be any of [Bootstrap image shapes](http://getbootstrap.com/css/#images)



[home](../readme.md)