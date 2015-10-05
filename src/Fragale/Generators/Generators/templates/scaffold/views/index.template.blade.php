@extends(Config::get("cruds.settings.layout", 'layouts.default'))

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
		<div class="col-md-9">
			@include('system.cruds.partial_header_cruds')
			@include('system.cruds.header_index_panel')
							
            <!-- bloque de datos -->
			@if (${{models}}->count())
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
			<!-- /bloque de datos -->
		</div>
		<!-- end #content -->			
<?php
/*------------------------------------------------------------*/
include_once($p->pathViews().'/system/cruds/footer_cruds.php');
/*------------------------------------------------------------*/
?>
@stop
