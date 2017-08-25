<?php
//index.php 1.0.0 Extract mejorado
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
//C:\xampp\htdocs\wwwsched
$sPathRoot = dirname(__FILE__);
$sPathRoot = str_replace("\\","/",$sPathRoot);
$arPaths = [
    get_include_path(),
    "$sPathRoot/the_application",
    "$sPathRoot/vendor",
    "$sPathRoot/vendor/composer",
    "$sPathRoot/vendor/fpdf",
    "$sPathRoot/vendor/theframework",
    "$sPathRoot/vendor/theframework",
    ];
$sPathInclude = implode(PATH_SEPARATOR,$arPaths);
set_include_path($sPathInclude);

require_once "vendor/autoload.php";
require_once "components/autoload.php";

$oComp = new TheFramework\Components\ComponentScheduler();
$oComp->run();