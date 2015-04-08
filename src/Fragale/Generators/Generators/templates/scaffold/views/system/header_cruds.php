<?php
/*----------------------------------------------------------------------------
| Crea el objeto manejador de argumentos para los CRUDs con master record
|
*/

$lc=new Fragale\Helpers\CrudsArgs($modelName);

/*----------------------------------------------------------------------------
| /resourses/views/cruds/objeto/customs/viewname_header.php
| Verifica si existe el archivo y en ese caso lo carga 
| como un include
|
*/

$filename=$p->pathViews()."/$modelName/customs/".$viewName.'_header.php';
if (file_exists($filename)){include_once($filename);}


/*----------------------------------------------------------------------------
| Configura el comportamiento general y las dimensiones 
| de las columnas del | GRID de Boostrap 3.
|
*/

$col_0_visible 	= $lc->config('col_0_visible');
$col_1_visible 	= $lc->config('col_1_visible');
$col_2_visible 	= $lc->config('col_2_visible');
$col_2_template = $lc->config('col_2_template');
$col_0_width 	= $lc->config('col_0_width');
$col_1_width 	= $lc->config('col_1_width');
$col_2_width 	= $lc->config('col_2_width');
$col_full 		= $lc->config('col_full');


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
$btnGoBack		=link_to_route($routeBtnIndex, trans('forms.goBack'), $lc->basicArgs(), array('class' => 'btn btn-success'));

/*habilitar o deshabilitar botones ''/'disabled' */
$classBtnIndex		='';
$classBtnEdit		='';
$classBtnDelete		='';
$classBtnBack		='';
$classBtnShow		='';

?>