@extends('layouts.default')

@section('content')
<?php
/*------------------------------------------------------------*/
$viewName="index";
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
				    <div class="panel {{$lc->config('panel_class')}}">
                       	<div class="panel-heading">
                            <h4 class="panel-title">{{trans('forms.'.$viewName)}}</h4>
                        </div>				    
						<div class="panel-body">					
							<div class="row">
								@include('system.cruds.header_index_panel') 
							</div>
							<div class="row">
							@if (${{models}}->count())
		                        <!--<table id="data-table" class="table table-striped table-hover table-bordered">	-->
		                        <table class="{{$lc->config('table_class')}}">	
									<!--<thead>-->
										<tr>
											{{headings}}
										</tr>
									<!--</thead>-->
									<!--<tbody>-->
										@foreach (${{models}} as ${{model}})
										<tr>
											{{fields}}
										</tr>
										@endforeach
									<!--</tbody>-->
								</table>
								{!! ${{models}}->render() !!}
							@else
								<?php
								$noRecords=true;
								$table=trans('forms.{{Models}}');
								$messaje=trans('forms.norecords');
								?>
								{{$messaje}} {{$table}}
							@endif
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
