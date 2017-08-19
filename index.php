<?php
//index.php 1.0.0 Extract mejorado
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
require_once "vendor/autoload.php";
require_once "vendor/theframework/components/autoload.php";

$oComp = new TheFramework\Components\ComponentScheduler();
$oComp->run();