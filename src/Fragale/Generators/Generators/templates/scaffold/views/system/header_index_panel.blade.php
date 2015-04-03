<?php 
    $filter=trim(Session::get("$modelName.filter", "")); 
    if(!isset($index)){
      $index="$modelName.index";
    }
?>
<div class="row">
<div class="{{$col_full}}" align="right">
  {!! link_to_route($routeBtnAdd,  trans('forms.addnew'), $lc->basicArgs(), array('class' => 'btn btn-primary'))!!}</li>


  
  <div class="btn-group m-r-5 m-b-5">
    <a href="javascript:;" class="btn btn-default">{{trans('forms.export')}}</a>
    <a href="javascript:;" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu pull-right">
      <li>{!! link_to_route("$index", 'Excel 2005 .xls', array_merge($lc->basicArgs(),array('exportar' => 'Excel5')), '') !!}</li>
      <li>{!! link_to_route("$index", 'Excel 2007 .xlsx', array_merge($lc->basicArgs(),array('exportar' => 'Excel2007')), '') !!}</li>
      <li class="divider"></li>
      <li><a href="javascript:;">Action 4</a></li>
    </ul>
  </div>
  <div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
      Dropdown
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
    </ul>
  </div>
</div>
</div>
