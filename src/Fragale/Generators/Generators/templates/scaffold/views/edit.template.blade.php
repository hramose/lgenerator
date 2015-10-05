@extends(Config::get("cruds.settings.layout", 'layouts.default'))

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
		<div class="col-md-9">

			@include('system.cruds.partial_header_cruds')

			{!! Form::model(${{model}}, array({{form_files}}'method' => 'PATCH', 'route' => array('{{models}}.update', ${{model}}->id))) !!}	

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
		<!-- end #content -->	
<?php
/*------------------------------------------------------------*/
include_once($p->pathViews().'/system/cruds/footer_cruds.php');
/*------------------------------------------------------------*/
?>
@stop
