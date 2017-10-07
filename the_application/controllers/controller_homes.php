<?php
namespace TheApplication\Controllers;

class ControllerHomes
{
    public function __construct()
    {

    }

    public function index()
    {
        $oComp = new \TheApplication\Components\ComponentScheduler();
        include("views/homes/view_index.php");
    }
    
    public function view()
    {
        bug("ControllerHomes.view");
    }
}