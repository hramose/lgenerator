<?php namespace Fragale\Helpers;

class Translation{

    function __construct() {
        //
    }

    static function translate($text, $file='forms')
    {
        if (Translation::needTranslation($text)){
            $text=trans($file.'.'.Translation::purge($text));
        }
        return $text;
    }

    static function bladeTranslate($text, $file='forms')
    {
        if (Translation::needTranslation($text)){
            $text="{{trans('$file.".Translation::purge($text)."')}}";
        }
        return $text;
    }


    static function purge($text)
    {
        if (Translation::needTranslation($text)){
            $text=str_replace('{', '', $text);
            $text=str_replace('}', '', $text);
            $text=str_replace('!', '', $text);
        }
        return $text;
    }    

    static function needTranslation($text)
    {
        if (substr($text,0,2)=='!{'){
          return true;
        }
        return false;
    }
}
?>
