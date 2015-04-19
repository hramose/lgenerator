@extends(Config::get("cruds.settings.layout", 'layouts.default'))

@section('content')
<?php
/*------------------------------------------------------------*/
$viewName="create";
$modelName="{{models}}"; 
$p=new Fragale\Helpers\PathsInfo;
include_once($p->pathViews().'/system/cruds/header_cruds.php'); 
/*------------------------------------------------------------*/
?>
			        
		<!-- begin #content -->
		<div id="content" class="content">

			@include('system.cruds.partial_header_cruds')			

			<!-- begin row -->
			<div class="row">
			    <!-- begin first column -->
			    <div class="{{$lc->config('col_1_width')}}">
			        <!-- begin panel -->
                    <div class="panel {{Config::get('cruds.settings.panel_class', 'panel-primary')}}">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{trans('forms.'.$viewName)}}</h4>
                        </div>                   
						<div class="panel-body">
							<div class="row">
								<div class="{{$lc->config('col_full')}}">
									{!! Form::open(array({{form_files}}'route' => '{{models}}.store')) !!}
									
										{{formElements}}
										{!! $lc->inputsMaster() !!}

										<!-- buttons -->
										<p class="divider"></p>
										{!! Form::submit(trans('forms.add'), array('class' => 'btn btn-info')) !!}
										{!! link_to_route($routeBtnIndex, trans('forms.Cancel'), $lc->basicArgs(), array('class' => 'btn btn-default '.$classBtnIndex)) !!}
										<!-- /buttons -->
										<p class="divider"></p>				
									{!! Form::close() !!}
								</div>
							</div>
						</div>		
                    </div>
                    <!-- end panel -->  
                </div>
                <!-- end first column -->			    				

			    <!-- begin second column -->
		    	@include('system.cruds.second_column_cruds')
                <!-- end second column -->			    				                
		    				
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->	                    

<?php
/*------------------------------------------------------------*/
include_once($p->pathViews().'/system/cruds/footer_cruds.php');
/*------------------------------------------------------------*/
?>
@stop
