			<!-- begin page-header -->
            <div class="row">
	            <div class="{{$lc->config('col_1_width')}}">		
					{{-- if are defined master record, then display it --}}
					@if ($lc->master_record_template)
					<div class="row">
						<div class="{{$lc->config('col_full')}}" id="crud-background">
							<p class="divider"></p>
							@include ($lc->master_record_template)
						</div>		
					</div>
					@endif							
					{{-- the title and text box --}}
		            <div class="row">
			            <div class="{{$lc->config('col_title')}}">		
							<h1 class="page-header">{!!$lc->icon_title!!} {!!$lc->title!!} <small>{!!$lc->subtitle!!}</small></h1>
						</div>
			            <div class="{{$lc->config('col_search_form')}}">		
							{{-- if are in index view, then display the search box --}}			
							@if ($viewName=='index')
							<!-- begin search form -->
							{!! Form::open(['route' => "$modelName.index",'method' => 'GET', 'class' => 'navbar-form navbar-left pull-right', 'role' =>'search']) !!}	
							  <div class="form-group">
							  	{!! Form::text('search', Request::old('search'), ['class' => 'form-control', 'placeholder' => 'Search']) !!}
							  <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>
							  </div>
							{!! Form::close() !!}	
							<!-- end search form -->		
							@endif	
						</div>				
					</div>
				</div>
			</div>			
			<!-- end page-header -->