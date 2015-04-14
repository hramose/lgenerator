###### Date fields using datepicker ######

First, you must enabled the bootstrap-datepicker, if it are not enabled yet, see how at the footer of this doc in the section [Enabling Datepicker and jquery access](doc/enable_datepicker.md)

For example to add the **date of birth** at the families table:

* just add the field date_of_birth:date and run 

i.e.:

```bash

	php artisan makefast:remove families --auto --dirs
	php artisan makefast:scaffold families --fields="first_name:string(64),last_name:string(64), gender:custom, employee_id:master, date_of_birth:date"

```

* now check the results in your browser!!.

surprised?




[home](../readme.md)