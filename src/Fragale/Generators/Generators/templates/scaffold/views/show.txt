@extends('layouts.default')

@section('content')
<?php
/*------------------------------------------------------------*/
$viewName="show";
$modelo="{{models}}";
$currentRecord=${{model}};
include_once(app_path().'/views/system/header_CRUD.php');
/*------------------------------------------------------------*/
?>

		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header">{{$titulo}} </h1>
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
                            <h4 class="panel-title">{{trans('forms.'.$viewName)}}</h4>
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
						    	<div class="{{$col_full}}" id="crud-background">
								{{ Form::open() }}

								    {{formElements}}

								    <p class="divider"></p>
								    <div class="row">
								        <div class="col-md-8" align="left">
											{{$btnGoBack}}
											{{ link_to_route($routeBtnEdit, trans('forms.Edit'), $lc->editArgs(${{model}}->id), array('class' => 'btn btn-info '.$classBtnEdit)) }}
								        </div>
								        <div class="col-md-4" align="right">
								        	<a href="{{$routeBtnDelete}}" role="button" class="btn btn-danger {{$classBtnDelete}}" align="right" data-toggle="modal">{{trans('forms.Delete')}}</a>
								        </div>
								    </div>	
								    <p class="divider"></p>
								{{ Form::close() }}
								</div>
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

<?php $keyDelete=${{model}}->id;?>

@include('layouts.kyrondeletemodal')

<?php
/*------------------------------------------------------------*/
include_once(app_path().'/views/system/footer_CRUD.php');
/*------------------------------------------------------------*/
?>
@stop
