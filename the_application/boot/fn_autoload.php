<?php
//the_application/fn_autoload
//autoload.php 1.0.2
//pr("boot/fn_autoload.php 1.0.1");
spl_autoload_register(function($sNSClassName)
{
    //bug($sNSClassName,"boot/autoload.php.sNSClassName:");
    $arPieces = explode("\\",$sNSClassName);
    $iPieces = count($arPieces);
    $sTypeof = isset($arPieces[$iPieces-2])?$arPieces[$iPieces-2]:"";
    if($sTypeof)
    {
        $sTypeof = strtolower($sTypeof);
        $sTypeof = substr($sTypeof,0,-1);
    } 
    //bug($sTypeof,"typeof");
    $sClassOriginal = end($arPieces);
    $sClassOrigLower = strtolower($sClassOriginal);
    
    $sFileUntyped = str_replace($sTypeof,"",$sClassOrigLower);
    $sFileUntyped = "$sFileUntyped.php";
    $sFileTyped = $sFileUntyped;
    $sFileTyped = "$sTypeof"."_"."$sFileUntyped";
    
    //para que la busque al final necesito la extension
    $sClassOriginal.=".php";
    //bug("sFileUntyped:$sFileUntyped,sFileTyped:$sFileTyped,sClassOriginal:$sClassOriginal");
    if(stream_resolve_include_path($sFileTyped))
        include_once $sFileTyped;
    elseif(stream_resolve_include_path($sFileUntyped))
        include_once $sFileUntyped;
    elseif(stream_resolve_include_path($sClassOriginal))
        include_once $sClassOriginal;
});//spl_autoload_register
