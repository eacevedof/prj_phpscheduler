<?php
//pr("boot_routes.php 1.0.0");
use \TheApplication\Components\ComponentRouter;

ComponentRouter::add("/view/","Homes","get_pdf");