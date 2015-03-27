<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Settings de las columnas del GRID los formularrios CRUDs
	|--------------------------------------------------------------------------
	| Este script se carga antes que el header de cualquier formulario, si se 
	| desea cambiar el comportamiento en un formulario especifico deben ser 
	| redefinidos estos valores dentro del header, con eso se lograra un 
	| comportamiento independiente para	ese formulario especificamente.
	| 	
	| Alcance = General (todos los CRUDs)
	| 	
	| 	** Para cambiar el comportamiento en un objeto especifico crear una
	| 	   subcarpeta con el nombre del objeto y copiar este archivo dentro
	| 	   ej:   	/config/cruds/objeto/settings.php
	| 	   default: /config/cruds/settings.php	
	| 	
	*/

	/*
	|--------------------------------------------------------------------------
	| Activa o desactiva la 2da columna en los formularios de CRUDs
	|--------------------------------------------------------------------------
	| 	
	*/	
	'col_0_visible'=>true,
	'col_1_visible'=>true,
	'col_2_visible'=>true,


	/*
	|--------------------------------------------------------------------------
	| El nombre por default del template de la 2da columna
	|--------------------------------------------------------------------------
	| 	
	*/	
	'col_2_template'=>'/layouts/forms_col2_template',


	/*
	|--------------------------------------------------------------------------
	| Establece el ancho de la 1ra y de la 2da columna 
	| (no deben superar 12 por el grid de boostrap 3)
	|--------------------------------------------------------------------------
	| 	
	*/	
	'col_0_width'=>'col-sm-2 col-md-2 col-xs-2',
	'col_1_width'=>'col-sm-10 col-md-10 col-xs-10',
	'col_2_width'=>'col-sm-2 col-md-2 col-xs-2',
	'col_full'=>'col-sm-12 col-md-12 col-xs-12',

];

?>