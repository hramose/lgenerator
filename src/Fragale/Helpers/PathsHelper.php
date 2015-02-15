<?php namespace Fragale\Helpers;


use Illuminate\Support\Facades\Config;
class PathsInfo{

    function __construct() {
        //
    }
    
	public function pathViews(){		    
      $path=Config::get('view.paths');
      return $path[0];
    }

    public function pathCustoms($name){		    
      $path=$this->pathViews().'/'.$name.'/customs';
      return $path;
    }

    public function pathCustomModel($name){		    
      $path=$this->pathCustoms($name).'/model';
      return $path;
    }

    public function pathCustomController($name){		    
      $path=$this->pathCustoms($name).'/controller';
      return $path;
    }

    public function pathCustomsTemplates($name){		    
      $path=$this->pathViews().'/Templates';
      return $path;
    }

}
?>
