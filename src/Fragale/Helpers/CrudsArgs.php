<?php namespace Fragale\Helpers;
/* Clase para el manejo de argumentos en los CRUDS */

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CrudsArgs 
{
    public $Master;
    public $master_id;
    public $master_record_col2_template;
    public $detail_records_col2_definitions;
    public $master_record_template;
    public $models;
    
    public function __construct($models)
    {

        $this->models=$models;

        $this->setSessionVars();

        /*template para la 2da columna*/        
        $template='/'.$this->models.'/customs/detail_records_col2';
        $filename=app_path().'/views'.$template.'.blade.php'; 
        if (!file_exists($filename)){
            $template='';
        }
        $this->detail_records_col2_definitions = $template; // template para los registros detalle si existen

        $master     = Input::get('master');
        $master_id  = Input::get('master_id');

        $models='0';

        $this->Master=ucwords(trim($master));       
        $this->master_id=$master_id;

        if(class_exists($this->Master)){
            $Master=$this->Master;
            $models=$Master::MODELS;                    
        }

        /*template para el master record*/
        $template="/$models/customs/master_record";
        $filename=app_path().'/views'.$template.'.blade.php';
        if (!file_exists($filename)){
            $template='';
        }
        $this->master_record_template = $template;   // template para el master record  

        /*template para la 2da columna*/
        $template="/$models/customs/master_record_col2";
        $filename=app_path().'/views'.$template.'.blade.php';
        if (!file_exists($filename)){
            $template='';
        }
        $this->master_record_col2_template = $template; // template para el master record si corresponde    
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

        Session::put($models.'.request_uri', $_SERVER['REQUEST_URI']);
        return true;
    }

    function getMasterRequestURI()
    {
        /*si tiene un master record entonces determina la URI del master (a la que tiene que retornar desde un detail) 
        si no tiene un master record devulve false */
        if(class_exists($this->Master)){
            $Master=$this->Master;
            $models=$Master::MODELS;                    
            return Session::get($models.'.request_uri', '');
        }
        return false;
    }

    function getMasterName()
    {
        if(class_exists($this->Master)){
            $Master=$this->Master;
            $models=$Master::MODELS;                    
            return trans('forms.backTo').' '.trans('forms.'.$models);
        }
        return false;
    }   

    function getMasterField($field)
    {
        $Master=$this->Master;
        $record=$Master::find($this->master_id);
        eval("\$value=\$record->$field;");
        return $value;
    }       

    function doTitle($title,$size='1')
    {
                $title ="<h$size>$title</h$size>";
        return $title;
    }           

    /*to be removed-------------------------------------------------------------------------------------------------*/
    function sortArgs($field,$order){       
        return array('sort' => $field, 'order' => $order, 'master' => $this->Master, 'master_id' => $this->master_id );
    }
}

