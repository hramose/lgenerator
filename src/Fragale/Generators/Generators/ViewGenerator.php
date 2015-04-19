<?php
namespace Fragale\Generators\Generators;

use Fragale\Helpers\PathsInfo;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Facades\Config;

class ViewGenerator extends Generator {


    public $viewName = '';
    public $viewDefinitions;
    public $templateCustomsPath;
    public $datepicker_script;
    public $picture_script;

    /**
     * Fetch the compiled template for a view
     *
     * @param  string $template Path to template
     * @param  string $name
     * @return string Compiled template
     */
    protected function getTemplate($template, $name)
    {
        $this->datepicker_script='';
        $this->picture_script='';
        $model = $this->cache->getModelName();  // post
        $models = Pluralizer::plural($model);   // posts

        $p=new PathsInfo();    
        $file=new File();
        $this->templateCustomsPath=$p->pathTemplatesCustoms()."/$models/views_definitions.json";

        $path=$this->templateCustomsPath; 
        if (file_exists($path))
        {
            $this->viewDefinitions = json_decode($file->get($path), true);
        }

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

        //$datepicker_script=$this->writeDatepickerScript();
        $datepicker_script=$this->writeScript($this->datepickerScript(), "datepicker.blade.php");
        $picture_script=$this->writeScript($this->pictureScript(), "picture.blade.php");

        $form_files='';
        //$pictures=$this->arrayOfPictures();
        if($this->arrayOfPictures()!='array()'){
          $form_files= "'files' => true, ";
        }

        // Replace template vars in view
        foreach(array('model', 'models', 'Models', 'Model', 'form_files') as $var)
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
          $this->makeMaster($model);
      	}

        $this->template = str_replace('{{headings}}', implode(PHP_EOL."\t\t\t\t", $headings), $this->template);
        $this->template = str_replace('{{fields}}', implode(PHP_EOL."\t\t\t\t\t", $fields) . PHP_EOL . $showLink.$editLink.$deleteLink, $this->template);

        return $this->template;
    }


    /**
     * Create the master detail record if needed
     *
     * @param  string $model
     * @return Array
     */
    protected function makeMaster($model)
    {
        $result=false;
        if (isset($this->viewDefinitions['detail_tables'])){
          $p=new PathsInfo();
          $file=new File(); 

          $models=basename(dirname($this->path));
          $Model=ucwords($model);
          if (isset($this->viewDefinitions['master_record_field'][0]['display'])){
            $display=$this->viewDefinitions['master_record_field'][0]['display'];
          }else{
            $display='$lc->master_record->id';
          }        
          
          $directory=dirname($this->path).'/master-detail';
          $file->makeDirectory($directory);


          /*make the master record access*/
          $file_path=$directory."/$models".'_master_record.blade.php';
          $buffer=$file->get($p->pathTemplatesViews().'/master-detail/master_record.template.blade.php');
          // Replace template vars in view
          foreach(array('Model', 'display') as $var){
              $buffer = str_replace('{{'.$var.'}}', $$var, $buffer);
          }  
          $result=$file->put($file_path, $buffer);

          /*make the detail tables access*/
          $file_path=$directory."/$models".'_detail_tables.blade.php';
          $bufferZ='';
          $buffer=$file->get($p->pathTemplatesViews().'/master-detail/detail_tables_item.template.blade.php');
          foreach ($this->viewDefinitions['detail_tables'] as $detail) {
            $bufferY=$buffer;
            $model_detail=$detail['model'];
            $display="{{route('$model_detail.index',['master' => '".strtolower($Model)."', 'master_id' => \$currentRecord->id ])}}";
            $description=$detail['description'];
            foreach(array('Model', 'display','description') as $var){
              $bufferY = str_replace('{{'.$var.'}}', $$var, $bufferY);
            }  
            $bufferZ=$bufferZ.$bufferY.PHP_EOL;
          }
          $buffer=$file->get($p->pathTemplatesViews().'/master-detail/detail_tables.template.blade.php');
          $buffer = str_replace('{{details}}', $bufferZ, $buffer);
          $result=$file->put($file_path, $buffer);

        }
        return $result;
    }


    /**
     * Create the table rows
     *
     * @param  string $model
     * @param  string $name     
     * @return Array
     */
    protected function makeTableRows($model,$name)
    {
        $models = Pluralizer::plural($model); // posts

        $fields = $this->purgedFields($model);

      	if($name==='index.blade'){
      	  /*crea las cabeceras de la tabla*/
      	  $ih=0; 
          $iconUp="\$lc->config('icon_sort-up')";
          $iconDown="\$lc->config('icon_sort-down')";
      	  foreach (array_keys($fields) as $field) {
            $headings[$ih]="<th>{{trans('forms." . ucwords($field) . "')}}<a href=\"{{route('{$models}.index', \$lc->sortArgs('$field','asc'))}}\">{!! $iconUp !!}</a>"."<a href=\"{{route('{$models}.index', \$lc->sortArgs('$field','desc'))}}\">{!! $iconDown !!}</a>"."</th>";
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
            $format=$this->formatField($field);
            if ($format!=""){
              $value="sprintf('$format', $value)";
            }           
            return "<td>{{{ $value }}}</td>";
        }, array_keys($fields));

	   //Modificacion, apertura de los links para show, edit y delete (Mayo 2014 se eliminan los links de edit y delete de la vista index)

      $showLink = <<<EOT
                                            <td>{!! link_to_route('{$models}.show', '', \$lc->showArgs(\${$model}->id), ['class' => \$lc->config('btn_class_view')] ) !!}</td>
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
        $name=$this->viewName;
        $fields = $this->cache->getFields();

        $key=str_replace('.blade', '', $name).'_disallowed';
        if(isset($this->viewDefinitions['field_definitions'][$key])){

            $disallowed=explode(',',$this->viewDefinitions['field_definitions'][$key]);
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
        $name=$this->viewName;
        $readonly = array();

        $key=str_replace('.blade', '', $name).'_readonly';
        if(isset($this->viewDefinitions['field_definitions'][$key])){

          $readonly=explode(',',$this->viewDefinitions['field_definitions'][$key]);
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
        $extra = array();

        $key='fields_extra';
        if(isset($this->viewDefinitions['field_definitions'][$key])){

          $extra=explode(',',$this->viewDefinitions['field_definitions'][$key]);
        }

        return $extra;
    }    

    /**
     * Verifica si existe un formato para ser aplicado a un campo con sprintf
     * solo aplica para las vistas show e index
     * @return string
     */
    public function formatField($field)
    {
        $format = '';

        $key=$field.'_format';
        if(isset($this->viewDefinitions['field_definitions'][$key])){

          $format=$this->viewDefinitions['field_definitions'][$key];
        }

        return $format;
    }    

    /**
     * Remove the php tags from a text
     *
     * @return string
     */
    public function purgePHPTags($text){
      return str_replace('<?php', '', $text);
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

        $fields = $this->purgedFields($model);  

        $fieldset_status='';
        if($this->viewName=='show.blade'){
          $fieldset_status='disabled';
        }

        $formMethods = array();

        /*Verifica si hay navtabs definidos en la vista*/

        if (isset($this->viewDefinitions['navtab_definitions']))
        {
            /*Formulario con navtabs*/
            $arrayTabs = $this->viewDefinitions['navtab_definitions'];

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
              
              $formMethods[] =<<<EOT
                          <fieldset $fieldset_status>
EOT;
              foreach ($fieldgroup as $id => $name) {
                $type=$fields[$name];                
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

        $attributes=$this->fieldAttributes($name, $type);
        $width = isset($attributes['width']) ? $attributes['width'] : 0;
        $height = isset($attributes['height']) ? $attributes['height'] : 0;


        /*Verifica si hay campos personalizados*/
        if(isset($this->viewDefinitions['customized_fields'][$name])){
          $custom=$this->viewDefinitions['customized_fields'][$name];
        }

        /*Pone el valor que leyó en cada campo*/
        if($this->viewName=='show.blade' and (! in_array($name, $this->extraFields($model) ) ) ) {
          $value="\$$model->$name";
        } else {
          $value="Request::old('$name')";
        }

        /*Pone un formato si corresponde*/
        if($this->viewName=='show.blade' or $this->viewName=='index.blade') {
          $format=$this->formatField($name);
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

        /*determina si el campo es de solo lectura*/
        if(isset($attributes['len'])){
          $size=$attributes['len'];
          $size = ", 'size' => '$size', 'maxlength' => '$size' ";
        }else{
          $size = "";
        }        

        switch($attributes['type'])
        {
            case 'integer':
               $element = "{!! Form::input('number', '$name', $value, array('class' => 'form-control' $readonlyClass $size )) !!}";
                break;
            case 'text':
                $element = "{!! Form::textarea('$name', $value, array('class' => 'form-control' $readonlyClass $size )) !!}";
                break;
            case 'boolean':
                $element = "{!! Form::checkbox('$name', $value, array('class' => 'form-control' $readonlyClass $size )) !!}";
                break;
            case 'date':
            case 'time':
            case 'datetime':                        
                $element = "{!! Form::text('$name', $value, array('class' => 'form-control', 'size' => '16' $readonlyClass )) !!}";
                $this->addDatepickerElement($name);
                break;                
            case 'custom':
                $element = str_replace('{{value}}', $value, $custom);
                break;
            case 'picture':
                if ($this->viewName === 'show.blade'){
                  $element = " ";
                }else{
                  $element = "<input type=\"file\" id=\"$name\" name=\"$name\" />";
                  $this->addPictureElement($name);
                }
                break;
            case 'master':
                $element = "<input name=\"$name\" type=\"hidden\" value=\"{{\$lc->master_id}}\">";
                break;    
            default:
                $element = "{!! Form::text('$name', $value, array('class' => 'form-control' $readonlyClass $size )) !!}";
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
        $model = $this->cache->getModelName();  // post

        $attributes=$this->fieldAttributes($name, $type);
        $width = isset($attributes['width']) ? $attributes['width'] : 0;
        $height = isset($attributes['height']) ? $attributes['height'] : 0;
        $type=$attributes['type'];

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
                    {!! Form::label('$name', $formalName,array( 'class'=> 'control-label')) !!}
                    <div class="input-group col-md-4 date $name">
                      $element
                      <span class="input-group-addon"><span class="glyphicon $dateicon"></span></span>
                    </div>
                    {{{ \$errors->first('$name') }}}
                </div>
                <!-- /$name -->

EOT;
          break;

          case 'picture':
            $object='$'.$model."->$name";

            if ($this->viewName === 'create.blade'){
            $imagen= <<<EOT
                        <img id="pic_$name" src="#" width="$width" height="$height" class="{{ \$lc->config('picture_class') }}" />
EOT;
            }

            if ($this->viewName === 'edit.blade'){
            $imagen= <<<EOT
                      @if(\$$model->$name)
                        <img id="pic_$name" src="/{{\$$model->$name}}" width="$width" height="$height" class="{{ \$lc->config('picture_class') }}" />
                      @else
                        <img id="pic_$name" src="#" width="$width" height="$height" class="{{ \$lc->config('picture_class') }}" />
                      @endif     
EOT;
            }

            if ($this->viewName === 'show.blade'){
            $imagen= <<<EOT
                        <img id="pic_$name" src="/{{\$$model->$name}}" width="$width" height="$height" class="{{ \$lc->config('picture_class') }}" />
EOT;
            }

            $frag = <<<EOT
                <!-- $name -->
                <div class="form-group {{{ \$errors->has('$name') ? 'has-error' : '' }}}">
                      $imagen
                      <div class="input-group $name">
                        $element
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
                    <div class="input-group col-md-4 $name">
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
                <!-- $name DEFAULT $type -->
                <div class="form-group {{{ \$errors->has('$name') ? 'has-error' : '' }}}">
                    {!! Form::label('$name', $formalName,array( 'class'=> 'control-label')) !!}
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

    /**
     * @return string
     */
    public function addDatepickerElement($name)
    {


            $element = <<<EOT
    \$('.$name').datepicker({
        language:  '<?php echo \$set_lang;?>',
        format: 'yyyy-mm-dd',        
        todayBtn: 1,
        todayHighlight: 1,
        showMeridian: 1,
        autoclose: 1
    });

EOT;
        $this->datepicker_script=$this->datepicker_script.$element.PHP_EOL;
        return true;

    }

    /**
     * @return string
     */
    public function datepickerScript()
    {
      $script='';

      if($this->datepicker_script!=''){
        $header = <<<EOT

<!--datepicker Script -->
<?php
\$set_lang=Lang::getLocale();
if (\$set_lang=='ar'){\$set_lang='es';} 
?>
<script type="text/javascript">

EOT;

      $footer = <<<EOT

</script>
<!--end datepicker Script -->
EOT;

        $script=$header.$this->datepicker_script.$footer.PHP_EOL;
      }

      return $script;
    }

    /**
     * agrega un elemento para el manejo de imagen al script    
     * @return string
     */
    public function addPictureElement($name)
    {

    $element = <<<EOT
    \$('#$name').change(function(){
        readURL(this, '#pic_$name');
    }); 

EOT;
        $this->picture_script=$this->picture_script.$element.PHP_EOL;
        return true;

    }   

    /**
     * genera el script de manipulacion de imagenes
     * @return string
     */
    public function pictureScript()
    {
      $script='';

      if($this->picture_script!=''){
        $header = <<<EOT

<!--picture manager Script -->
<script type="text/javascript">
function readURL(input, picture) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            \$(picture).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

EOT;

      $footer = <<<EOT

</script>
<!--end picture manager Script -->
EOT;

        $script=$header.$this->picture_script.$footer.PHP_EOL;
      }

      return $script;
    }

    /**
     * escribe el archivo con el script 
     * @return string
     */
    public function writeScript($script, $script_filename)
    {

        $viewName=str_replace('.blade', '', $this->viewName);
        if($script!='' and ($viewName=='create' or $viewName=='edit')){
          $model = $this->cache->getModelName();  // post
          $models = Pluralizer::plural($model);   // posts

          $p=new PathsInfo();    
          $file=new File();
          $result=$file->put($p->pathViews()."/cruds/$models/$viewName".'_'.$script_filename, $script);        
        }else{
          $result=false;
        }

        return $result;
    }



}
