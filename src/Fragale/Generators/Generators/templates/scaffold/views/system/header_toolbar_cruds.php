<?php
/*----------------------------------------------------------------------------
| Barra de desplazamiento y herramientas que muestra la vista show
| /resourses/views/system/cruds/header_toolbar_cruds.php
|
*/
if($viewName=='show'){
	$currentKeyId=$currentRecord->id;
	$nextKeyId=$currentRecord->getNextId($currentKeyId);
	$prevKeyId=$currentRecord->getPreviousId($currentKeyId);
	$firstKeyId=$currentRecord->getIdMaxOrMin('min');
	$lastKeyId=$currentRecord->getIdMaxOrMin('max');

	$classD1=$classD2=$classD3=$classD4='';

	if ($currentKeyId==$firstKeyId){$classD1='disabled';	}
	if ($currentKeyId==$prevKeyId){$classD2='disabled';	}
	if ($currentKeyId==$nextKeyId){$classD3='disabled';	}
	if ($currentKeyId==$lastKeyId){$classD4='disabled';	}

	$linkL1=link_to_route($routeBtnAdd, '', $lc->basicArgs(), array('class' => 'btn btn-info fa fa-file-o '));
	$linkL2=link_to_route($routeBtnEdit, '', $lc->editArgs($currentKeyId), array('class' => 'btn btn-info fa fa-edit '));
	$linkL3=link_to_route($routeBtnEdit, '', $lc->editArgs($currentKeyId), array('class' => 'btn btn-info fa fa-copy disabled'));
	$linkL4="<a href=\"$routeBtnDelete\" role=\"button\" class=\"btn btn-danger fa fa-trash-o $classBtnDelete\" align=\"right\" data-toggle=\"modal\"></a>";
	$linkD1=link_to_route($routeBtnShow, '', $lc->showArgs($firstKeyId), array('class' => 'btn btn-info fa fa-step-backward '.$classD1));
	$linkD2=link_to_route($routeBtnShow, '', $lc->showArgs($prevKeyId), array('class' => 'btn btn-info fa fa-backward '.$classD2));
	$linkD3=link_to_route($routeBtnShow, '', $lc->showArgs($nextKeyId), array('class' => 'btn btn-info fa fa-forward '.$classD3));
	$linkD4=link_to_route($routeBtnShow, '', $lc->showArgs($lastKeyId), array('class' => 'btn btn-info fa fa-step-forward '.$classD4));
    $toolbar =<<<EOT
	<div class="row-fluid" align="right">		
		<div class="btn-group">
			$linkD1
			$linkD2
			$linkD3
			$linkD4
		</div>
		<div class="btn-group">
			$linkL1
			$linkL2
			$linkL3
		</div>
		<div class="btn-group">			
			$linkL4
		</div>
	</div> 
EOT;
};

?>
