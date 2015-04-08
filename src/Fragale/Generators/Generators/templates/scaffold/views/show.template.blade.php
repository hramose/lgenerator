@extends('layouts.default')

@section('content')
<?php
/*------------------------------------------------------------*/
$viewName="show";
$modelName="{{models}}"; 
$currentRecord=${{model}};
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
							{!! $lc->toolBar(${{model}}) !!}
							<div class="row">
						    	<div class="{{$lc->config('col_full')}}">
								{!! Form::open() !!}
								    {{formElements}}
								    <p class="divider"></p>
								    <div class="row">
								        <div class="col-md-8" align="left">
											{!! $btnGoBack !!}
								        </div>
								        <div class="col-md-4" align="right">								        	
                                        </div>
								    </div>	
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
