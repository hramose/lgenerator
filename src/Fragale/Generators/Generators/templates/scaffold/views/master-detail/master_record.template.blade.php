                    <!-- {{Model}} Master records --> 
                    @if($lc->Master)
                            <ul class="list-group details-list">
                                <li class="list-group-item">
	                                <h2>
		                                <a href="{{route($lc->master_record_models.'.show',['id' => $lc->master_record->id])}}">
		                                	{{{{display}}}}
		                                </a>
	                                </h2>
                                </li>
                            </ul>
                    @endif

