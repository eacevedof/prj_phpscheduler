<?php
//the_application/boot/autoload.php
require_once "autoload.php";

use TheApplication\Components\ComponentRouter;

$oComp = new ComponentRouter();
bug($oComp);