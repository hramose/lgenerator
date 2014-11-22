@extends('layouts.default')

@section('content')
<?php
/*------------------------------------------------------------*/
$viewName="index";
$modelo="{{models}}";
include_once(app_path().'/views/system/header_CRUD.php'); 
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
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">{{$titulo}}</h4>
                        </div>
                        <div class="panel-body">                        
							<div class="row-fluid">
								@if ($lc->master_record_template)
								<div class="{{$col_full}}" id="crud-background">
									<p class="divider"></p>
									@include ($lc->master_record_template)
								</div>		
								@endif		
								@include('layouts.kyronindexheader') 
							</div>
							<div class="row-fluid">
								@if (${{models}}->count())
	                            <div class="table-responsive">
	                                <table id="data-table" class="table table-striped table-hover table-bordered">	
										<thead>
											<tr>
												{{headings}}
											</tr>
										</thead>
										<tbody>
											@foreach (${{models}} as ${{model}})
											<tr>
												{{fields}}
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
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
                <!-- end col-12 -->			    				
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->			
<?php
/*------------------------------------------------------------*/
include_once(app_path().'/views/system/footer_CRUD.php');
/*------------------------------------------------------------*/
?>
@stop
