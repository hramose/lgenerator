@extends('layouts.default')

@section('content')
<?php
/*------------------------------------------------------------*/
$viewName="edit";
$modelo="{{models}}";
include_once(app_path().'/views/system/header_CRUD.php');
/*------------------------------------------------------------*/
?>

<div id="container-fluid"> <!--envoltura del formulario-->
	<div class="row-fluid">
		<div class="{{$col_full}}" id="crud-background">
			<p class="divider"></p>
			@if ($lc->master_record_template)
				@include ($lc->master_record_template)
			@endif		
			{{$titulo}}
		</div>			
	</div>
	<div class="row-fluid">
		<div class="{{$col_full}}" id="crud-background">
			{{ Form::model(${{model}}, array('method' => 'PATCH', 'route' => array('{{models}}.update', ${{model}}->id))) }}	

				{{formElements}}
				{{ $lc->inputsMaster() }}

				<!-- buttons -->
				<p class="divider"></p>
				<div class="form-group">
				{{ Form::submit(trans('forms.Update'), array('class' => 'btn btn-warning')) }}
				{{ link_to_route($routeBtnShow, trans('forms.Cancel'), $lc->editArgs(${{model}}->id), array('class' => 'btn btn-default '.$classBtnShow)) }}
				</div>
				<!-- /buttons -->
				<p class="divider"></p>
			{{ Form::close() }}
		</div>
	</div>
</div> <!--/envoltura del formulario-->
<?php
/*------------------------------------------------------------*/
include_once(app_path().'/views/system/footer_CRUD.php');
/*------------------------------------------------------------*/
?>
@stop
