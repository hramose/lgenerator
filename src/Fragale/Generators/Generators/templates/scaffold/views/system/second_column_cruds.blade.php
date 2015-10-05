<?php
    //Layout de la 2da columna del template principal de los CRUDs
    $have_detail_records=0;
    $details_template='cruds/'.$modelName.'/master-detail/'.$modelName.'_detail_tables';
    if(file_exists($p->pathViews().'/'.$details_template.'.blade.php')){
        $have_detail_records=1;    
    }                    
?>
@include('system.cruds.notifications_layout')

@if ($have_detail_records===1)
    @include($details_template)
@endif

 

