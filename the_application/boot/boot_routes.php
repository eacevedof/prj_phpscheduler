<?php
//pr("boot_routes.php 1.0.1");
use \TheApplication\Components\ComponentRouter as R;

R::add("/pdf/","Homes","get_pdf");