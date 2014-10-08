<?php
namespace Fragale\Generators\Generators;

use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem as File;

class ViewGenerator extends Generator {


    public $viewName = '';

    /**
     * Fetch the compiled template for a view
     *
     * @param  string $template Path to template
     * @param  string $name
     * @return string Compiled template
     */
    protected function getTemplate($template, $name)
    {
        $this->template = $this->file->get($template);

        if ($this->needsScaffolding($template))
        {
            return $this->getScaffoldedTemplate($name);
        }

        // Otherwise, just set the file
        // contents to the file name
        return $name;
    }

    /**
     * Get the scaffolded template for a view
     *
     * @param  string $name
     * @return string Compiled template
     */
    protected function getScaffoldedTemplate($name)
    {
        $model = $this->cache->getModelName();  // post
        $models = Pluralizer::plural($model);   // posts
        $Models = ucwords($models);             // Posts
        $Model = Pluralizer::singular($Models); // Post

        $this->viewName=$name;

        //var_dump($this->cache);

        // Create,Edit and Show views require form elements
        if ($name === 'create.blade' or $name === 'edit.blade' or $name === 'show.blade')
        {
            $formElements = $this->makeFormElements();

            $this->template = str_replace('{{formElements}}', $formElements, $this->template);
        }

        // Replace template vars in view
        foreach(array('model', 'models', 'Models', 'Model') as $var)
        {
            $this->template = str_replace('{{'.$var.'}}', $$var, $this->template);
        }

        // And finally create the table rows
	      // Modificacion, se separan los links
        /*list($headings, $fields, $editAndDeleteLinks) = $this->makeTableRows($model);*/
      	list($headings, $fields, $editLink, $showLink, $deleteLink) = $this->makeTableRows($model,$name);
      	if($name === 'show.blade'){
      	  $showLink="";
      	}
      	if($name === 'index.blade'){
      	  $editLink="";
      	  $deleteLink="";
      	}

        $this->template = str_replace('{{headings}}', implode(PHP_EOL."\t\t\t\t", $headings), $this->template);
        $this->template = str_replace('{{fields}}', implode(PHP_EOL."\t\t\t\t\t", $fields) . PHP_EOL . $showLink.$editLink.$deleteLink, $this->template);

        return $this->template;
    }

    /**
     * Create the table rows
     *
     * @param  string $model
     * @return Array
     */
    protected function makeTableRows($model,$name)
    {
        $models = Pluralizer::plural($model); // posts

        //$fields = $this->cache->getFields();
        $fields = $this->purgedFields($model);

      	if($name==='index.blade'){
      	  /*crea las cabeceras de la tabla*/
      	  $ih=0; //print_r($fields);exit();
      	  foreach (array_keys($fields) as $field) {
            $headings[$ih]="<th>{{trans('forms." . ucwords($field) . "')}}<a href=\"{{route('{$models}.index', \$lc->sortArgs('$field','asc'))}}\"><span class=\"{{Config::get('kyron.icon_sort-up')}}\"></span></a>"."<a href=\"{{route('{$models}.index', \$lc->sortArgs('$field','desc'))}}\"><span class=\"{{Config::get('kyron.icon_sort-down')}}\"></span></a>"."</th>";      
      	    $ih++;
      	  }
      	}else{
      	  // First, we build the table headings
      	  $headings = array_map(function($field) {
      	      return "<th>{{trans('forms." . ucwords($field) . "')}}</th>";
      	  }, array_keys($fields)); 
      	}
        $headings[]="<th> - </th>";

        // And then the rows, themselves
        $fields = array_map(function($field) use ($model) {
            $value="\$$model->$field";
            $format=$this->formatField($model,$field);
            if ($format!=""){
              $value="sprintf('$format', $value)";
            }           
            //return "<td>{{{ \$$model->$field }}}</td>";
            return "<td>{{{ $value }}}</td>";
        }, array_keys($fields));


        // Now, we'll add the edit and delete buttons.

	   //Modificacion, apertura de los links para show, edit y delete (Mayo 2014 se eliminan los links de edit y delete de la vista index)

      $showLink = <<<EOT
                    <td>{{ link_to_route('{$models}.show', trans('forms.Show'), \$lc->showArgs(\${$model}->id), array('class' => 'btn btn-info btn-xs')) }}</td>
EOT;
      $deleteLink = "";
      $editLink = "";

        return array($headings, $fields, $editLink, $showLink, $deleteLink);
    }

    /**
     * Elimina los campos que no son permitidos en los formularios 
     *
     * @return array
     */
    public function purgedFields($model)
    {
        $models = Pluralizer::plural($model); // posts
        $name=$this->viewName;

        $fields = $this->cache->getFields();

        $path=app_path()."/views/$models/customs/formfields_layout.php";
        if (file_exists($path))
        {
            $file=new File();
            $invalidFields = json_decode($file->get($path), true);
            $key=str_replace('.blade', '', $name).'_disallowed';
            if (array_key_exists($key, $invalidFields)) {
              $disallowed=explode(',',$invalidFields[$key]);
            }
            $fields = array_except($fields, $disallowed);
        }
        
        return $fields;
    }


    /**
     * Verifica si hay campos de solo lectura, usualmente para el formulario de "edicion"
     *
     * @return array
     */
    public function readonlyFields($model)
    {
        $models = Pluralizer::plural($model); // posts
        $name=$this->viewName;
        $readonly = array();

        $path=app_path()."/views/$models/customs/formfields_layout.php";
        if (file_exists($path))
        {
            $file=new File();
            $readonlyFields = json_decode($file->get($path), true);
            $key=str_replace('.blade', '', $name).'_readonly';
            if (array_key_exists($key, $readonlyFields)) {
              $readonly=explode(',',$readonlyFields[$key]);
            }
        }        
        return $readonly;
    }

    /**
     * Verifica si hay campos que no pertenecen al modelo y que son "extra"
     *
     * @return array
     */
    public function extraFields($model)
    {
        $models = Pluralizer::plural($model); // posts
        $extra = array();

        $path=app_path()."/views/$models/customs/formfields_layout.php";
        if (file_exists($path))
        {
            $file=new File();
            $extraFields = json_decode($file->get($path), true);
            $key='fields_extra';
            if (array_key_exists($key, $extraFields)) {
              $extra=explode(',',$extraFields[$key]);
            }
        }        
        return $extra;
    }    

    /**
     * Verifica si existe un formato para ser aplicado a un campo con sprintf
     * solo aplica para las vistas show e index
     * @return string
     */
    public function formatField($model,$field)
    {
        $models = Pluralizer::plural($model); 
        $format = '';

        $path=app_path()."/views/$models/customs/formfields_layout.php";
        if (file_exists($path))
        {
            $file=new File();
            $formats = json_decode($file->get($path), true);
            $key=$field.'_format';
            if (array_key_exists($key, $formats)) {
              $format=$formats[$key];
            }
        }        
        return $format;
    }    


    /**
     * Add Laravel methods, as string,
     * for the fields
     *
     * @return string
     */
    public function makeFormElements()
    {
        $model = $this->cache->getModelName();  // post
        $models = Pluralizer::plural($model);   // posts

        $fields = $this->purgedFields($model);  

        $fieldset_status='';
        if($this->viewName=='show.blade'){
          $fieldset_status='disabled';
        }

        $formMethods = array();

        /*Verifica si hay navtabs definidos en la vista*/
        $path=app_path()."/views/$models/customs/navtabs.php";
        if (file_exists($path))
        {
            /*Formulario con navtabs*/
            $file=new File();
            $arrayTabs = json_decode($file->get($path), true);
            //$fields = $this->cache->getFields();

            $formMethods[] =<<<EOT
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">            
EOT;
            $class="class=\"active\"";
            foreach ($arrayTabs as $tab => $fieldgroup) {
            $formMethods[] =<<<EOT
              <li $class><a href="#$tab" data-toggle="tab">{{{trans('forms.$tab')}}}</a></li>
EOT;
            $class="";
            }
            $formMethods[] =<<<EOT
            </ul>
EOT;

            $formMethods[] =<<<EOT
            <!-- Nav tabs contents -->
            <div class="tab-content">
EOT;
            $class="in active";
            foreach ($arrayTabs as $tab => $fieldgroup) {
            $formMethods[] =<<<EOT
              <!-- Nav tabs contents for tab $tab -->
              <div class="tab-pane fade $class" id="$tab">
EOT;
              //var_dump($fields);
              $formMethods[] =<<<EOT
                          <fieldset $fieldset_status>
EOT;
              foreach ($fieldgroup as $id => $name) {
                $type=$fields[$name];
                //echo "name= $name type=$type";
                $element=$this->makeFormField($name,$fields[$name]);
                $formMethods[] = $this->makeFormGroup($name, $element,$type);                
              }
              $formMethods[] =<<<EOT
                          </fieldset>
EOT;

            $formMethods[] =<<<EOT
              </div>
EOT;
            $class="";
            }
            $formMethods[] =<<<EOT
            </div>
EOT;
        }else{
            /*Formulario sin navtabs*/
              $formMethods[] =<<<EOT
                          <fieldset $fieldset_status>
EOT;

            foreach($fields as $name => $type)
            {  
                $element=$this->makeFormField($name,$type);
                $formMethods[] = $this->makeFormGroup($name, $element, $type);
            }
        }
              $formMethods[] =<<<EOT
                          </fieldset>
EOT;
        return implode(PHP_EOL, $formMethods);
    }


    /**
     * 
     * 
     *
     * @return string
     */
    public function makeFormField($name, $type)
    {

        $model = $this->cache->getModelName();  // post
        $models = Pluralizer::plural($model);   // posts

        /*Verifica si hay campos personalizados*/
        $path=app_path()."/views/$models/customs/formfields.php";
        if (file_exists($path))
        {
            /*Levanta los campos personalizados*/
            $file=new File();
            $customFields = json_decode($file->get($path), true);
            if (array_key_exists($name, $customFields)) {
              $custom=$customFields[$name];
            }
        }

        /*Pone el valor que leyó en cada campo*/
        if($this->viewName=='show.blade' and (! in_array($name, $this->extraFields($model) ) ) ) {
          $value="\$$model->$name";
        } else {
          $value="Request::old('$name')";
        }

        /*Pone un formato si corresponde*/
        if($this->viewName=='show.blade' or $this->viewName=='index.blade') {
          $format=$this->formatField($model,$name);
          if ($format!=""){
            $value="sprintf('$format', $value)";
          } 
        } 

        /*determina si el campo es de solo lectura*/
        if(in_array($name, $this->readonlyFields($model))){
          $readonlyClass = ", 'readonly' => ''";
        }else{
          $readonlyClass = "";
        }

        switch($type)
        {
            case 'integer':
               $element = "{{ Form::input('number', '$name', $value, array('class' => 'form-control' $readonlyClass )) }}";
                break;
            case 'text':
                $element = "{{ Form::textarea('$name', $value, array('class' => 'form-control' $readonlyClass )) }}";
                break;
            case 'boolean':
                $element = "{{ Form::checkbox('$name', $value, array('class' => 'form-control' $readonlyClass )) }}";
                break;
            case 'date':
            case 'time':
            case 'datetime':                        
                $element = "{{ Form::text('$name', $value, array('class' => 'form-control', 'size' => '16' $readonlyClass )) }}";
                break;                
            case 'custom':
                $element = str_replace('{{value}}', $value, $custom);
                break;
            case 'master':
                $element = "<input name=\"$name\" type=\"hidden\" value=\"{{\$lc->master_id}}\">";
                break;               
            default:
                $element = "{{ Form::text('$name', $value, array('class' => 'form-control' $readonlyClass )) }}";
                break;
        }
        return $element;
    }


    /**
     * @return string
     */
    public function makeFormGroup($name, $element, $type)
    {
        $formalName = "trans('forms.".ucwords($name)."')";

        if($type=='date'){ $dateicon='glyphicon-calendar'; }
        if($type=='time'){ $dateicon='glyphicon-time'; }
        if($type=='datetime'){ $dateicon='glyphicon-th'; }

        switch($type)
        {
          /*campos date, time y datetime */
          case 'datetime':          
          case 'time':          
          case 'date':
            $frag = <<<EOT
                <!-- $name -->
                <div class="form-group {{{ \$errors->has('$name') ? 'has-error' : '' }}}">
                    {{ Form::label('$name', $formalName,array( 'class'=> 'control-label')) }}
                    <div class="input-group col-md-4 date $name">
                      $element
                      <span class="input-group-addon"><span class="glyphicon $dateicon"></span></span>
                    </div>
                    {{{ \$errors->first('$name') }}}
                </div>
                <!-- /$name -->

EOT;
          break;
          case 'master':
            $frag = <<<EOT
                <!-- $name -->
                <div class="form-group {{{ \$errors->has('$name') ? 'has-error' : '' }}}">
                    <div class="input-group col-md-4 date $name">
                      $element
                    </div>
                    {{{ \$errors->first('$name') }}}
                </div>
                <!-- /$name -->

EOT;
          break;          
          /*campos por defecto*/
          default:
            $frag = <<<EOT
                <!-- $name -->
                <div class="form-group {{{ \$errors->has('$name') ? 'has-error' : '' }}}">
                    {{ Form::label('$name', $formalName,array( 'class'=> 'control-label')) }}
                    <div class="controls">
                    $element
                    {{{ \$errors->first('$name') }}}
                    </div>    
                </div>
                <!-- /$name -->

EOT;
          break;
        }

            return $frag;     

    }

}
