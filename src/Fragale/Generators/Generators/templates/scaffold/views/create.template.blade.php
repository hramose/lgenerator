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
		<div class="col-md-9">

			@include('system.cruds.partial_header_cruds')			

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
		<!-- end #content -->	                    

<?php
/*------------------------------------------------------------*/
include_once($p->pathViews().'/system/cruds/footer_cruds.php');
/*------------------------------------------------------------*/
?>
@stop
