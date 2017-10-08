<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Models\ModelEmployee
 * @file model_employee.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Models;

use TheApplication\Models\TheApplicationModel;

class ModelEmployee extends TheApplicationModel
{

    public function __construct($arData=[])
    {
        $this->arData = $arData;
        $this->sPath = TFW_PATH_APPLICATIONDS."models/json/employee.json";
    }
    
    public function insert()
    {}
    
    public function update()
    {}   
    
    public function delete()
    {}
    
    public function get_data()
    {
        
    }

}//ModelEmployee