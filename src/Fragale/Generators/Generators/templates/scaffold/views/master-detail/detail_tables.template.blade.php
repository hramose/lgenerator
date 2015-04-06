
                    @if($viewName=='show')
                    <!-- Detail tables --> 
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            {{trans('forms.relatedTables')}}
                        </div>
                        <div class="panel-body">
		                    <ul class="list-group details-list">
		                        {{details}}
		                    </ul>
                        </div>
                        <div class="panel-footer">
                            -
                        </div>
                    </div>
                    @endif