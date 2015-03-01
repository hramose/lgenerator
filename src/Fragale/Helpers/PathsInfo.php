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
          /forms                      pathCustomForms($objectname)
            aditionalFormFields.php   fileAditionalFormsFields($objectname)
            navtabs.php               fileFormNavtabs($objectname)
            formFiedsLayout.php       fileFormFieldsLayout($objectname)
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

    /*path al template personalizado de formularios para un objeto $name*/
    public function pathCustomForms($name){       
      return $this->pathTemplates()."/customs/$name/forms";
    }

    /*path al template de vistas*/
    public function fileViewTemplate($name,$onlyFileName = false){       
      $path='';
      if(!$onlyFileName){
        $path=$this->pathTemplatesViews().'/';
      }
      return $path."$name.template.blade.php";
    }    

    /*archivo con el template personalizado de campos adicionales en los formularios para un objeto $name*/
    /* Ej:    
    {
      "type":"{{ Form::select('type', array('bug'=>'Bug', 'function'=>'Funcionalidad','develop'=>'Desarrollo'), {{value}}, array('class' => 'form-control')) }}",
      "status":"{{ Form::select('status', array('open'=>'Open', 'solved'=>'Solved','closed'=>'Closed','closed_unsolved'=>'Closed_Unsolved'), {{value}}, array('class' => 'form-control')) }}"
    }
    */    
    public function fileAditionalFormsFields($name){       
      return $this->pathCustomForms($name)."/aditionalFormFields.php";
    }

    /*archivo con el template personalizado de la distribucion de navtabs en los formularios para un objeto $name*/
    /* Ej:    
    {
     "general":["table_type_id","code","description","comments"],
     "extras":["txt_value_1","txt_value_2","num_value_1","num_value_2","date_value_1","date_value_2","bool_value_1","bool_value_2"]
    }    
    */
    public function fileFormNavtabs($name){       
      return $this->pathCustomForms($name)."/navtabs.php";
    }

    /*archivo con el template personalizado de la distribucion de campos en los formularios para un objeto $name*/
    /* Ej:
    {
      "_all":"id,type,description,user_id,status,from_issue_id",
      "_comment":"indicar los campos no se deben generar en los formularios",
      "index_disallowed":"user_id,from_issue_id",
      "edit_disallowed":"user_id,from_issue_id",
      "create_disallowed":"id,user_id,from_issue_id",
      "show_disallowed":"id,user_id,from_issue_id",
      "_comment":"indicar los campos que son de solo lectura",
      "edit_readonly":"id",
      "_comment":"campos con formato especial en index y en show",
      "id_format":"#%d"
    }
    */    
    public function fileFormFieldsLayout($name){       
      return $this->pathCustomForms($name)."/formFieldsLayout.php";
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
