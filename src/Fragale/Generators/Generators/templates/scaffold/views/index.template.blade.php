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
			<!-- begin page-header -->
			<h1 class="page-header">{{$titulo}} <small>{{$subtitulo}}</small></h1>
			<!-- end page-header -->

			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="{{$col_full}}">
				    <div class="panel panel-default">
						<!--<div class="row-fluid">-->
						<div class="panel-heading">
							@if ($lc->master_record_template)
							<div class="{{$col_full}}" id="crud-background">
								<p class="divider"></p>
								@include ($lc->master_record_template)
							</div>		
							@endif		
							@include('layouts.kyronindexheader') 
						</div>
						<!--<div class="row-fluid">-->
						<div class="panel-body">					
							@if (${{models}}->count())
		                        <!--<table id="data-table" class="table table-striped table-hover table-bordered">	-->
		                        <table class="table table-striped">	
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
                <!-- end col-12 -->			    				
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
