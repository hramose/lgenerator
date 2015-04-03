							<div class="row">
								@if ($lc->master_record_template)
								<div class="{{$col_full}}" id="crud-background">
									<p class="divider"></p>
									@include ($lc->master_record_template)
								</div>		
								@endif										
							</div>