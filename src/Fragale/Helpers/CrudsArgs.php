<?php namespace Fragale\Helpers;
/* Clase para el manejo de argumentos en los CRUDS */

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Fragale\Helpers\PathsInfo;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Config;

class CrudsArgs 
{
 
    public $Master;
    public $master_id;
    public $master_record_template;
    public $master_record;
    public $master_record_models;
    public $models;
    public $title;
    public $subtitle;
    public $icon_title;
    public $viewname;
    
    public function __construct($models, $viewname)
    {

        $p=new PathsInfo();

        $this->models=$models;
        $this->viewname=$viewname;

        $this->title=$this->config('title');
        $this->subtitle=$this->config('subtitle');
        $this->icon_title=$this->config("icon_title_$viewname");        

        $this->setSessionVars();

        $master     = Input::get('master');
        $master_id  = Input::get('master_id');

        $models='0';

        $this->Master=ucwords(trim($master));       
        $this->master_id=$master_id;
        $Master='App\\cruds\\'.$this->Master;


        if(class_exists($Master)){            
            $models=$Master::MODELS;                    
            $object=new $Master;
            $this->master_record=$object->find($master_id);
            $this->master_record_models=$models;
        }

        /*template para el master record*/
        $master_models = strtolower(Pluralizer::plural($this->Master));   // el directorio del master record
        $template="/cruds/$master_models/master-detail/".$master_models."_master_record";
        $filename=$p->pathViews().$template.'.blade.php';        
        if (!file_exists($p->pathViews().$template.'.blade.php')){
            $template='';
        }
        $this->master_record_template = $template;   // template para el master record  

    }


    function showArgs($id){     
        return array($id, 'master' => $this->Master, 'master_id' => $this->master_id );
    }

    function editArgs($id){     
        return $this->showArgs($id);
    }

    function moveArgs($id,$direction){      
        $show=$this->showArgs($id);
        $move=array('move' => $direction);
        return array_merge ($show,$move);
    }

    function basicArgs($master='',$master_id=''){       
        if($master==''){
            $master     =$this->Master;
            $master_id  =$this->master_id;
        }
        return array('master' => $master, 'master_id' => $master_id );
    }

    function inputsMaster()
    {
        return "<input name=\"master\" type=\"hidden\" value=\"".$this->Master."\">"."<input name=\"master_id\" type=\"hidden\" value=\"".$this->master_id."\">";;
    }

    function stringAddMaster($link)
    {
        return $this->doStringLink($link,$this->Master,$this->master_id);
    }

    function doStringLink($link,$master_model,$master_id)
    {
        if (str_contains($link,'?')){
            $prefijo='&';
        } else {
            $prefijo='?';
        }

        $link = $link.$prefijo.'master='.$master_model.'&master_id='.$master_id;
        return $link;
    }

    function setSessionVars()
    {
        /*establece su propia URI request*/
        $models=$this->models;
        //echo($models.'.request_uri'.' '.$_SERVER['REQUEST_URI']);
        //exit();
        Session::put($models.'.request_uri', $_SERVER['REQUEST_URI']);
        return true;
    }

    function getMasterRequestURI()
    {
        /*si tiene un master record entonces determina la URI del master (a la que tiene que retornar desde un detail) 
        si no tiene un master record devulve false */
        $Master='App\\cruds\\'.$this->Master;  
        if(class_exists($Master)){
            $models=$Master::MODELS;                    
            return Session::get($models.'.request_uri', '');
        }
        return false;
    }

    function getMasterName()    
    {
        $Master='App\\cruds\\'.$this->Master;        
        if(class_exists($Master)){
            $models=$Master::MODELS;                    
            return trans('forms.backTo').' '.trans('forms.'.$models);
        }
        return false;
    }   

    function getMasterField($field)
    {
        $Master='App\\cruds\\'.$this->Master; 
        $record=$Master::find($this->master_id);
        eval("\$value=\$record->$field;");
        return $value;
    }       

    function sortArgs($field,$order){       
        return array('sort' => $field, 'order' => $order, 'master' => $this->Master, 'master_id' => $this->master_id );
    }



function toolBar($record){ 

    /*links botones*/
    $btnGoBack      =link_to_route($this->models.'.index', trans('forms.goBack'), $this->basicArgs(), array('class' => 'btn btn-success'));

    $currentKeyId=$record->id;
    $nextKeyId=$record->getNextId($currentKeyId);
    $prevKeyId=$record->getPreviousId($currentKeyId);
    $firstKeyId=$record->getIdMaxOrMin('min');
    $lastKeyId=$record->getIdMaxOrMin('max');
    $classBtnDelete     ='';

    $classD1=$classD2=$classD3=$classD4='';

    if ($currentKeyId==$firstKeyId){$classD1='disabled';}
    if ($currentKeyId==$prevKeyId){$classD2='disabled'; }
    if ($currentKeyId==$nextKeyId){$classD3='disabled'; }
    if ($currentKeyId==$lastKeyId){$classD4='disabled'; }

    $linkL0=$this->toolButton('index',$record->id);
    $linkL1=$this->toolButton('create',$record->id);
    $linkL2=$this->toolButton('edit',$record->id);
    $linkL3=$this->toolButton('copy',$record->id,'disabled');
    $linkL4=$this->toolButton('destroy',$record->id);

    $linkD1=link_to_route($this->models.'.show', '', $this->showArgs($firstKeyId), array('class' => 'btn btn-info glyphicon glyphicon-step-backward '.$classD1));
    $linkD2=link_to_route($this->models.'.show', '', $this->showArgs($prevKeyId), array('class' => 'btn btn-info glyphicon glyphicon-chevron-left '.$classD2));
    $linkD3=link_to_route($this->models.'.show', '', $this->showArgs($nextKeyId), array('class' => 'btn btn-info glyphicon glyphicon-chevron-right '.$classD3));
    $linkD4=link_to_route($this->models.'.show', '', $this->showArgs($lastKeyId), array('class' => 'btn btn-info glyphicon glyphicon-step-forward '.$classD4));
    
    $toolbar =<<<EOT
    <div class="row" align="right">  
        <div class="col-md-6">
            <div class="btn-group">         
                $linkL0
            </div>
        </div>                 
        <div class="col-md-6">
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
    </div> 
EOT;

    return $toolbar;
    }

    function toolButton($action,$id,$disabled=''){ 
        $route=$this->models.'.'.$action;
        switch ($action) {
            case 'index':
            case 'create':
                $html=link_to_route($route, '', $this->basicArgs(), array('class' => $this->config("btn_class_$action").' '.$disabled));
                break;
            case 'edit':        
                $html=link_to_route($route, '', $this->editArgs($id), array('class' => $this->config("btn_class_$action").' '.$disabled));
                break;
            case 'copy':        
                $html=link_to_route($this->models.'.edit', '', $this->editArgs($id), array('class' => $this->config("btn_class_$action").' '.$disabled));
                break;            
            case 'show':
                $html=link_to_route($route, '', $$this->showArgs($id), array('class' => $this->config("btn_class_$action").' '.$disabled));
                break;
            case 'destroy':
                $confirmation="if(!confirm('".trans('forms.AreSureToDelete')."?')){return false;};";
                $html=Form::open(array('route' => array($route, $id), 'method' => 'delete'));
                $html=$html."<button type=\"submit\" class=\"".$this->config("btn_class_$action")."\" onclick=\"".$confirmation."\" title=\"Delete this Item\" ></button>";
                $html=$html.Form::close();
                break;

            case 'remove_filter':
                $html=link_to_route($this->models.'.index', '', array_merge($this->basicArgs(), ['filter'=>'#reset#']), array('class' => $this->config('btn_class_remove_filter')));
                break;

            default:
                $html='';
                break;
        }
        return $html;
    }

    /*
    * Return the $value for $name entry in config/cruds/settings.php
    * if $models is present then return the same entry but read from config/cruds/$models/settings.php 
    */

    function config($name,$extract_class=false){ 

        $models=$this->models;
        $value = Config::get("cruds.$models.settings.$name", Config::get("cruds.settings.$name"));

        /*if the value is a function translate then execute it*/
        if (substr($value,0,6)=='trans(') {
            eval('$value='.$value.';');
        }else{
            if($extract_class){
                $ini_pos=strpos($value, 'class=')+7;
                $end_pos=strpos($value, '"',$ini_pos);
                $value=substr($value, $ini_pos,$end_pos-$ini_pos);
            }            
        }

        return $value;
    }    


    /*
    * make an HTML radio button group
    * options array example: ['f' => 'Female','m' => 'Male']
    *
    * return @string
    */

    function radio($name, $options,$current_value=''){
        $result='';
        foreach ($options as $option => $label) {
            if($option==$current_value){

                $checked='checked';
            }else{
                $checked='';
            }
            $result=$result."<label class=\"control-label\"><input $checked type=\"radio\" id=\"$name-$option\" name=\"$name\" value=\"$option\">$label</label>".PHP_EOL;
        }
        return $result;
    }

}
