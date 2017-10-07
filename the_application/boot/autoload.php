<?php
pr("boot/autoload.php");
//the_application/autoload
//autoload.php 1.0.0
spl_autoload_register(function($sNSClassName)
{
    bug($sNSClassName,"boot/autoload.php.sNSClassName:");
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
});//spl_autoload_register
