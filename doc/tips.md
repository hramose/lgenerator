#### TIPs ####

to generate and regenerate your application CRUDs, you can write a bash file with this code:

```bash

	#!/bin/sh
	echo "Generando los CRUDs de la aplicacion ..."

	php artisan makefast:remove employees --auto --dirs
	php artisan makefast:scaffold employees --fields="first_name:string(64),last_name:string(64),gender:string(1)"

	php artisan makefast:remove families --auto --dirs
	php artisan makefast:scaffold families --fields="first_name:string(64),last_name:string(64)"

```

save the file and name it as `makeapp` or how you preffer and set executable permissions

```bash
sudo chmod 755 makeapp
```

then when you need to re-build the application, just run the makeapp script.   ;)

(*for WIN users, it can be a `.bat` file*)


[home](../readme.md)