<?php namespace Fragale\Helpers;

use Illuminate\Support\Facades\Config;

/*

/resourses
  /views                              pathViews()
  /templates
    /cruds                            pathTemplates()
      /model                          pathTemplatesModel()
          model.template.php          fileModelTemplate()                      
      /controller                     pathTemplatesController()
          controller.template.php     fileControllerTemplate()                
      /views                          pathTemplatesViews() 
          index.template.blade.php    fileViewTemplate('index')                 
          create.template.blade.php   fileViewTemplate('create')                 
          edit.template.blade.php     fileViewTemplate('edit')                 
          delete.template.blade.php   fileViewTemplate('delete')                                               
      /customs                        pathTemplatesCustoms()
        /objectname
          /model                      pathCustomModel($objectname)
            model.template.php        fileCustomModel($objectname)            
            rules.template.php        fileCustomRules($objectname)
          /controller                 pathCustomController($objectname)
            controller.template.php   fileCustomController($objectname)          
*/

class PathsInfo{

    function __construct() {
        //
    }
    /*el path donde estan alojadas las vistas en esta aplicacion*/
    public function pathViews(){		    
      $path=Config::get('view.paths');
      return $path[0];
    }

    /*el path donde estan alojados los templates, en el mismo nivel que las vistas*/
    public function pathTemplates(){ 
      return str_replace('views', 'templates/cruds', $this->pathViews());
    }

    /*path al template general de modelos*/
    public function pathTemplatesModel(){ 
      return $this->pathTemplates().'/model';
    }

    /*path al template general de vistas*/
    public function pathTemplatesViews(){ 
      return $this->pathTemplates().'/views';
    }    

    /*path al template general de customs*/
    public function pathTemplatesCustoms(){ 
      return $this->pathTemplates().'/customs';
    }       

    /*file con el template general de modelos*/
    public function fileModelTemplate(){ 
      return $this->pathTemplatesModel().'/model.template.php';
    }

    /*path al template general de controladores*/
    public function pathTemplatesController(){ 
      return $this->pathTemplates().'/controller';
    }   

    /*file con el template general de controladores*/
    public function fileControllerTemplate(){ 
      return $this->pathTemplatesController().'/controller.template.php';
    }     

    /*path al template personalizado de modelos para un objeto $name*/
    public function pathCustomModel($name){		    
      return $this->pathTemplates()."/customs/$name/model";
    }

    /*archivo con el template personalizado del modelo para un objeto $name*/
    public function fileCustomModel($name){       
      return $this->pathCustomModel($name)."/model.template.php";
    }

    /*archivo con el template personalizado para las rules de un objeto $name*/
    public function fileCustomRules($name){       
      return $this->pathCustomModel($name)."/rules.template.php";
    }

    /*path al template personalizado de controlador para un objeto $name*/
    public function pathCustomController($name){       
      return $this->pathTemplates()."/customs/$name/controller";
    }

    /*archivo con el template personalizado del controlador para un objeto $name*/
    public function fileCustomController($name){       
      return $this->pathCustomController($name)."/controller.template.php";
    }

    /*path al template de vistas*/
    public function fileViewTemplate($name,$onlyFileName = false){       
      $path='';
      if(!$onlyFileName){
        $path=$this->pathTemplatesViews().'/';
      }
      return $path."$name.template.blade.php";
    }    

    public function testAndSwapFileName($defaultFilename,$alternativeFilename){       
        $filename=$defaultFilename;
        if (file_exists($alternativeFilename)){
            $filename=$alternativeFilename;
        }
        return $filename;
    }

}
?>
