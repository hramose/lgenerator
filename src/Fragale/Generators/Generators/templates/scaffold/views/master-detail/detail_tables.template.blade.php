
                    @if($viewName=='show')
                    <!-- Detail tables --> 
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-One">
                                    {{{ trans('forms.relatedTables') }}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-One" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <ul class="list-group details-list">
                                        {{details}}
                                    </ul>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif