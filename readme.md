Laravel 5.0 CRUDs generator
===========================


This Laravel 5 package provides a fully customizable CRUDs generators to speed up your development process. These generators include:

 - `makefast:crudstructure`
 - `makefast:scaffold`
 - `makefast:navtab`
 - `makefast:remove`


*I was inspired for this work using the Jeffrey Way's generators, I get the code from the version 1.0 and use it as a base for my project.   Thanks Jeffrey.*

If you are looking for a "generic" generator is recommended to use way/generators

**this package is to be included in an existing Laravel project, if you still do not have one, then you can install it from scratch:**

*composer create-project laravel/laravel yourprojectname dev-develop --prefer-dist*

**then proceeds with the installation**




* 1. [Installation ](doc/Installation.md)
* 2. [Create the CRUD structure for the generator ](doc/crudstructure.md)
* 3. [Enable Bootstrap 3.0 ](doc/bootstrap.md)
* 3.1. [Check your Bootstrap installation](doc/checkbootstrap.md)
* 4. [Usage ](#)
* 4.1. [You need a table ](doc/youneedatable.md)
* 4.2. [Scaffolding the CRUDs ](doc/scaffolding.md)
* 4.2.1. [Field types ](#)
* 4.2.1.1. [Text ](#)
* 4.2.1.2. [Numeric ](#)
* 4.2.1.3. [Date (using datepicker)](doc/datepicker.md)
* 4.2.1.4. [Radio buttons ](doc/radio.md)
* 4.2.1.5. [CheckBoxes (booleans) ](#)
* 4.2.1.6. [Select ](#)
* 4.2.1.7. [DB Select ](#)
* 4.2.1.8. [Custom ](doc/customs.md)
* 4.2.1.9. [Picture ](doc/picture.md)  <---- NEW
* 4.2.2. [Customizing the views](doc/howitspossible.md)
* 4.2.2.1. [How it's possible ](doc/howitspossible.md)
* 4.2.2.2. [Disabling some fields in views ](doc/hideafield.md)
* 4.2.2.3. [Applying format to a field ](#)
* 4.2.2.4. [Read only fields ](#)
* 4.2.2.5. [Navs ](doc/navtabs.md)
* 4.2.2.6. [Master-Detail ](doc/masterdetail.md)
* 4.2.3. [Customizing the models](doc/models.md)
* 4.2.3.1. [Validation rules ](doc/rules.md)
* 5. [Excel / Office exportations ](doc/exportations.md)
* 6. [How to remove a resource ](doc/remove.md)
* 7. [Changing some settings ](doc/settings.md)









#### Note ####


**feel free to modify any template under `resources/templates/cruds`, be carefully with the layouts**

**make a backup of the project before install this lgenerator**



I am writing the documentation... please be patient



I need partners to contribute to this project in some respects:
My native language is Spanish, then you might find some syntax errors in paragraphs that I wrote in English, if you want to contribute ... great.

I also need :
* to make video tutorials in English and Spanish.
* check the code
* check the performance



PLEASE NOTE THAT I AM CURRENTLY DEVELOPING THIS PACKAGE. 
THE TIME THAT I'M DEDICATING TO THIS PROJECT IS CONDITIONED BY MY DAILY DUTIES, IF YOU WANT, YOU CAN CONTACT ME IN fragale@gmail.com

DAILY I WILL UPLOAD NEW FEATURES,
