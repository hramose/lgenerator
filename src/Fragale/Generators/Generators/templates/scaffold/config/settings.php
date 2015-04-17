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
	'col_0_width'=>'col-xs-6 col-md-3',
	'col_1_width'=>'col-xs-12 col-sm-6 col-md-9',
	'col_2_width'=>'col-xs-6 col-md-3',
	'col_full'=>'col-sm-12 col-md-12 col-xs-12',



	/*
	|--------------------------------------------------------------------------
	| Icon titles for the CRUDs forms
	|--------------------------------------------------------------------------
	| 	
	*/	
	'icon_title_index'	=>'<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>',
	'icon_title_show'	=>'<span class="glyphicon glyphicon-file" aria-hidden="true"></span>',
	'icon_title_edit'	=>'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
	'icon_title_create'	=>'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',

	'icon_sort-up'	=>'<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>',
	'icon_sort-down'	=>'<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>',

	/*
	|--------------------------------------------------------------------------
	| Classes for toolbar buttons
	|--------------------------------------------------------------------------
	| 	
	*/	
    'btn_class_index' => 'btn btn-info glyphicon glyphicon-list-alt',
    'btn_class_create' => 'btn btn-info glyphicon glyphicon-plus',
    'btn_class_edit' => 'btn btn-info glyphicon glyphicon-edit',
    'btn_class_copy' => 'btn btn-info glyphicon glyphicon-duplicate',
    'btn_class_show' => 'btn btn-info glyphicon glyphicon-step-backward',
    'btn_class_destroy' => 'btn btn-danger glyphicon glyphicon-trash',	
    'btn_class_search' => 'btn btn-info glyphicon glyphicon-search',	
    'btn_class_remove_filter' => 'btn btn-warning glyphicon glyphicon-refresh',	

	/*
	|--------------------------------------------------------------------------
	| The button in the index view that link to show a record
	|--------------------------------------------------------------------------
	| 	
	*/	
    'btn_class_view' => 'btn btn-info glyphicon glyphicon-option-horizontal btn-sm',

	/*
	|--------------------------------------------------------------------------
	| The table in the index view
	|--------------------------------------------------------------------------
	| 	
	*/	
    'table_class' => 'table table-striped table-hover',

	/*
	|--------------------------------------------------------------------------
	| La clase aplicada a los panel contenedores delos CRUDs
	|--------------------------------------------------------------------------
	| 	
	*/	

	'panel_class'=>'panel-primary',

	'col_title'	=>'col-xs-8 col-sm-6 col-md-8',
	'col_search_form'=>'col-xs-4 col-sm-6 col-md-4',

	/*--------------------------------------------------------------------------
	| Form's Titles and subtitles
	|---------------------------------------------------------------------------
	| 	
	*/	
	'title'=>"trans('forms.'.\$this->models)",
	'subtitle'=>"trans('forms.view_'.\$this->viewname)",

	/*--------------------------------------------------------------------------
	| Picture & image classes
	|---------------------------------------------------------------------------
	| 	
	*/	
	'picture_class' =>"img-rounded",
	'pictures_path' =>"uploads/pictures",

];

?>