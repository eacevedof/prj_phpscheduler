<?php
//components autoload
//autoload.php 1.1.0
spl_autoload_register(function($sNSClassName)
{
    $arClass = explode("\\",$sNSClassName);
    $sCompClassName = end($arClass);
    $sCompClassName = str_replace("Component","",$sCompClassName);
    $sClassName = strtolower($sCompClassName);
    $sClassName = "$sClassName.php";
    $sCompClassName = "component_$sClassName";
    if(stream_resolve_include_path($sCompClassName))
        include_once $sCompClassName;
    elseif(stream_resolve_include_path($sClassName))
        include_once $sClassName;    
    elseif(function_exists("lg"))
    {
        lg("Class not found: $sCompClassName or $sClassName");
    }
    else 
    {
        echo "Class not found: $sCompClassName or $sClassName";
    }
});//spl_autoload_register

