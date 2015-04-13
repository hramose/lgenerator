		<!DOCTYPE html>
		<html lang="en">
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"> 
			<link href="{{ asset('assets/plugins/bootstrap/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
		    <body>		
				<div id="page-container">
					<div class="container-fluid">
						<div class="row">
						  	@if($lc->config('col_1_visible'))
						  	<div class="{{$lc->config('col_full')}}">
								@yield('content')
							</div> 
							@endif		
						</div>
					</div>			
				</div>
			<script src="{{ asset('assets/plugins/jquery/jquery/jquery.min.js') }}"></script>
			<script src="{{ asset('assets/plugins/bootstrap/bootstrap/js/bootstrap.min.js') }}"></script>
			<script src="{{ asset('assets/plugins/bootstrap/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
			<script src="{{ asset('assets/plugins/bootstrap/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>

			@include('system.cruds.datepicker_loader')
				
			</body>	
		</html>