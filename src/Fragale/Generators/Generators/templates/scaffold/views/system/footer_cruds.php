<?php
/*----------------------------------------------------------------------------
| /resourses/views/cruds/objeto/customs/viewname_footer.php
| Verifica si existe el archivo y en ese caso lo carga 
| como un include
|
*/
$filename=$p->pathViews()."/cruds/$modelo/customs/$viewName"."_footer.php";
if (file_exists($filename)){include_once($filename);}

/*----------------------------------------------------------------------------
| /resourses/views/cruds/objeto/customs/viewname_footer_javascripts.php
| Verifica si existe el archivo y en ese caso lo carga 
| como un include
|
*/
$filename_footer_javascripts=str_replace('.php','_javascripts.php',$filename);
if (file_exists($filename)){include_once($filename);}

?>