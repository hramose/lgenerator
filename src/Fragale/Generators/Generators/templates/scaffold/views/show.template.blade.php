@extends(Config::get("cruds.settings.layout", 'layouts.default'))

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
		<div class="col-md-9">

			@include('system.cruds.partial_header_cruds')

        	<!-- bloque de formulario -->                    
			{!! $lc->toolBar(${{model}}) !!}
			<p class="divider"></p>
			@include('system.cruds.second_column_cruds')
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
			<!-- /bloque de formulario -->
		</div>
		<!-- end #content -->	
<?php
/*------------------------------------------------------------*/
include_once($p->pathViews().'/system/cruds/footer_cruds.php');
/*------------------------------------------------------------*/
?>
@stop
