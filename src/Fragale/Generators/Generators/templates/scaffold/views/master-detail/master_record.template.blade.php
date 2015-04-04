                    <!-- Master record -->
                    @if($lc->Master)
                            <ul class="list-group details-list">
                                <li class="list-group-item"><h2>{{$lc->getMasterField('title')}}</h2></li>
                            </ul>
                    @endif
