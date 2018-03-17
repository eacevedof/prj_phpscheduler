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

    public function get_keyname()
    {
        $arData = [];
        foreach($this->arData as $arEmp)
            $arData[$arEmp["id"]] = $arEmp["name"];
        asort($arData);
        return $arData;
    }
    
    public function get_by_workplace($sPlace="")
    {
        $arEmployees = array_filter($this->arData,function($arEmployee) use($sPlace) {
            $arEmployee["workplace"] = (isset($arEmployee["workplace"])?$arEmployee["workplace"]:"");
            return (strstr($arEmployee["workplace"],$sPlace));
        });
        
        $arEmployees = array_map(function($arEmployee){
           return $arEmployee["id"]; 
        },$arEmployees);
        
        asort($arEmployees);
        return $arEmployees;
    }
    
}//ModelEmployee