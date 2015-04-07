<?php
    //Layout de la 2da columna del template principal de los CRUDs
    $load_detail=0;
    $details_template='cruds/'.$modelName.'/master-detail/'.$modelName.'_detail_tables';
    if(file_exists($p->pathViews().'/'.$details_template.'.blade.php')){
        $load_detail=1;    
    }                    
?>
            @if(isset($col_2_visible)) 
                <div class="{{$col_2_width}}">

                    @include('/layouts/forms_col2_notifications')
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Notificaciones w {{$modelName}}
                        </div>
                        <div class="panel-body">
                            <p>No hay ninguna notificación.</p>
                        </div>
                        <div class="panel-footer">
                            -
                        </div>
                    </div>

                    @if ($load_detail===1)
                    @include($details_template)
                    @endif

                </div>
            @endif
