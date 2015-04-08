{{-- Layout cargador de las notificaciones de sesion --}}

                    <!-- Notificaciones -->
                    @if (Session::has('message'))
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            {{ trans('forms.notifications') }}
                        </div>
                        <div class="panel-body">
		                    @include('system.cruds.partial_notifications')
		                    <!-- Notificaciones de sesion-->
		                    <div class="flash alert">
		                        <p>{{ Session::get('message') }}</p>
		                    </div>
                        </div>
                        <div class="panel-footer">
                            -
                        </div>
                    </div>                    
                    @endif
                    <!-- ./ notificaciones -->
                    