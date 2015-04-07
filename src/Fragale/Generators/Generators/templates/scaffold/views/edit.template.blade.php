@extends('layouts.default')

@section('content')
<?php
/*------------------------------------------------------------*/
$viewName="edit";
$modelName="{{models}}"; 
$p=new Fragale\Helpers\PathsInfo;
include_once($p->pathViews().'/system/cruds/header_cruds.php'); 
/*------------------------------------------------------------*/
?>
		<!-- begin #content -->
		<div id="content" class="content">

			<!-- begin page-header -->
            <div class="row">
	            <div class="{{$col_full}}">		
					@include('system.cruds.partial_header_cruds')
					<h1 class="page-header">{!!$icon_title!!} {!!$form_title!!} </h1>
				</div>
			</div>			
			<!-- end page-header -->

			<!-- begin row -->
			<div class="row">			
			    <!-- begin first column -->
			    <div class="{{$col_1_width}}">
			        <!-- begin panel -->
					<div class="panel {{Config::get('cruds.settings.panel_class', 'panel-primary')}}">	
                        <div class="panel-heading">
                            <h4 class="panel-title">{{trans('forms.'.$viewName)}}</h4>
                        </div>							        
						<div class="panel-body">  
							<div class="row">
								<div class="{{$col_full}}" id="crud-background">
									{!! Form::model(${{model}}, array('method' => 'PATCH', 'route' => array('{{models}}.update', ${{model}}->id))) !!}	

										{{formElements}}
										{!! $lc->inputsMaster() !!}

										<!-- buttons -->
										<p class="divider"></p>
										<div class="form-group">
										{!! Form::submit(trans('forms.Update'), array('class' => 'btn btn-warning')) !!}
										{!! link_to_route($routeBtnShow, trans('forms.Cancel'), $lc->editArgs(${{model}}->id), array('class' => 'btn btn-default '.$classBtnShow)) !!}
										</div>
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
