<?php
/*----------------------------------------------------------------------------
| Crea el objeto manejador de argumentos para los CRUDs con master record
|
*/

$lc=new Fragale\Helpers\CrudsArgs($modelName, $viewName);

/*----------------------------------------------------------------------------
| /resourses/views/cruds/objeto/customs/viewname_header.php
| Verifica si existe el archivo y en ese caso lo carga 
| como un include
|
*/

$filename=$p->pathViews()."/$modelName/customs/".$viewName.'_header.php';
if (file_exists($filename)){include_once($filename);}

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