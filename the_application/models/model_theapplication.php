<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Models\TheApplicationModel
 * @file model_theapplication.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Models;

use TheFramework\Main\TheFrameworkModel;

class TheApplicationModel extends TheFrameworkModel
{
    protected $arData;
    protected $sPath;
    
    public function __construct()
    {

    }

    public function load()
    {
        $this->arData = $this->json_read($this->sPath);
    }
    
    protected function json_write($arData,$sPath)
    {
        $sJson = json_encode($arData);
        file_put_contents($sPath,$sJson);
    }//json_write
    
    protected function json_read($sPath=NULL)
    {
        if($sPath)
        {
            $sContent = file_get_contents($sPath);
            $arJson = json_decode($sContent,TRUE);
            return $arJson;
        }
        return [];
    }//json_read  
    
    
}//TheApplicationModel