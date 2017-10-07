<?php
namespace TheApplication\Controllers;

class ControllerHomes
{
    public function __construct()
    {

    }

    public function index()
    {
        bug("ControllerHomes.run");
        include("views/homes/view_index.php");
    }
    
    public function view()
    {
        bug("ControllerHomes.view");
    }
}