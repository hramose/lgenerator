<?php
/*----------------------------------------------------------------------------
| /resourses/views/cruds/objeto/customs/viewname_header.php
| Verifica si existe el archivo y en ese caso lo carga 
| como un include
|
*/
$filename=$p->pathViews()."/$modelName/customs/".$viewName.'_header.php';
if (file_exists($filename)){include_once($filename);}


/*----------------------------------------------------------------------------
| Configura el comportamiento general y las dimensiones de las columnas del 
| GRID de Boostrap 3.
| el archivo de configuracion lo lee de /config/cruds/settings.php para una
| configuracion particular para un objeto se puede utilizar la ruta
| /config/cruds/objeto/settings.php
|
*/
$col_0_visible 	= Config::get("cruds.$modelName.settings.col_0_visible", Config::get('cruds.settings.col_0_visible'));
$col_1_visible 	= Config::get("cruds.$modelName.settings.col_1_visible", Config::get('cruds.settings.col_1_visible'));
$col_2_visible 	= Config::get("cruds.$modelName.settings.col_2_visible", Config::get('cruds.settings.col_2_visible'));
$col_2_temlpate = Config::get("cruds.$modelName.settings.col_2_template", Config::get('cruds.settings.col_2_template'));
$col_0_width 	= Config::get("cruds.$modelName.settings.col_0_width", Config::get('cruds.settings.col_0_width'));
$col_1_width 	= Config::get("cruds.$modelName.settings.col_1_width", Config::get('cruds.settings.col_1_width'));
$col_2_width 	= Config::get("cruds.$modelName.settings.col_2_width", Config::get('cruds.settings.col_2_width'));
$col_full 		= Config::get("cruds.$modelName.settings.col_full", Config::get('cruds.settings.col_full'));

/*----------------------------------------------------------------------------
| Crea el objeto manejador de argumentos para los CRUDs con master record
|
*/

$lc=new Fragale\Helpers\CrudsArgs($modelName);

/*----------------------------------------------------------------------------
| Prepara el titulo y el subtitulo del formulario
|
*/
$form_title=trans('forms.'.$modelName);
$form_subtitle=trans('forms.view_'.$viewName);
/*if ($viewName!='index'){
	$form_title=$lc->doTitle($form_title,'3');
}
*/
$icon_title	= Config::get("cruds.settings.icon_title_$viewName", '');

/*----------------------------------------------------------------------------
| Algunos seteos complementarios
|
*/
$noRecords=false; // establece en falso en indicador de falta de registros

/*links botones*/
$routeBtnIndex		=$modelName.'.index';
$routeBtnAdd		=$modelName.'.create';
$routeBtnEdit		=$modelName.'.edit';
$routeBtnShow		=$modelName.'.show';
$routeBtnDelete	='#DeleteModal';
$btnGoBack		=link_to_route($routeBtnIndex, trans('forms.goBack'), $lc->basicArgs(), array('class' => 'btn btn-success'));

/*habilitar o deshabilitar botones ''/'disabled' */
$classBtnIndex		='';
$classBtnEdit		='';
$classBtnDelete		='';
$classBtnBack		='';
$classBtnShow		='';


/*----------------------------------------------------------------------------
| Carga la barra de desplazamiento y herramientas que muestra la vista show
| /resourses/views/system/cruds/header_toolbar_cruds.php
|
*/
if($viewName=='show'){
	$filename=$p->pathViews().'/system/cruds/header_toolbar_cruds.php';
	if (file_exists($filename)){include_once($filename);}
}
?>