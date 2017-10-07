<?php
//index.php 2.0.0
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
//C:\xampp\htdocs\wwwsched\the_public
$sPathPublic = dirname(__FILE__);
//var_dump($sPathPublic);die;
$sPathPublic = str_replace("\\","/",$sPathPublic);
$sPathProject = "$sPathPublic/..";
$arPaths = [
    get_include_path(),
    "$sPathProject",
    "$sPathProject/the_application",
    "$sPathProject/the_application/boot",
    "$sPathProject/the_application/behaviours",
    "$sPathProject/the_application/components",
    "$sPathProject/the_application/controllers",
    "$sPathProject/the_application/helpers",
    "$sPathProject/the_application/models",
    "$sPathProject/the_application/views",
    "$sPathProject/the_application/views/element",
    "$sPathProject/the_application/views/reactjs",
    //VENDOR
    "$sPathProject/the_vendor",//tiene el autoload de composer
    ];
$sPathInclude = implode(PATH_SEPARATOR,$arPaths);
set_include_path($sPathInclude);

require_once "the_vendor/autoload.php";//atuload para composer
require_once "boot/bootstrap.php";//the_application/boot/bootsrap.php

use TheApplication\Components\ComponentRouter;
$arRun = ComponentRouter::run();
if($arRun)
{
    $oTfwController = new $arRun["controller"]();
    if(method_exists($oTfwController,$arRun["method"]))
        $oTfwController->{$arRun["method"]}();
    else
    {
        die("404");
    }
}
