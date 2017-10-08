<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Models\ModelSchedule
 * @file model_schedule.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Models;

use TheApplication\Models\TheApplicationModel;

class ModelSchedule extends TheApplicationModel
{   
    
    public function __construct($arData=[])
    {
        $this->arData = $arData;
        $this->sPath = TFW_PATH_APPLICATIONDS."models/json/schedule.json";
    }
    
    public function load()
    {
        $this->arData = $this->json_read($this->sPath);
    }
    
    public function insert()
    {}
    
    public function update()
    {}   
    
    public function delete()
    {}
    
    public function get_data()
    {
        return $this->arData;
    }
    
    public function get_data_by($sValue,$sType="m")
    {
        $arData = $this->arData;
        switch($sType) 
        {
            case "m":
                return (isset($arData[$sValue]))?$arData[$sValue]:[];
            break;
            case "d":
                //hay que explotar el día
                return (isset($arData[$sValue]))?$arData[$sValue]:[];
            break;
            case "H":
                //hay que explotar el hora
                return (isset($arData[$sValue]))?$arData[$sValue]:[];
            break;        
            default:
                return [];
            break;
        }//switch
    }

}//ModelSchedule