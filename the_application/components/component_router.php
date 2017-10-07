<?php
/**
* @author Eduardo Acevedo Farje.
* @link www.eduardoaf.com
* @version 1.0.0
* @name ComponentRouter 
* @file component_router.php
* @date 07-10-2017 11:23 (SPAIN)
* @observations: 
* @requires:
*/
namespace TheApplication\Components;

class ComponentRouter
{

    private static $sReqUri;
    private static $arMessages = [];
    private static $arUrls = [];
    public static $arRun = [];

    public function __construct()
    {
        ;
    }

    public static function add($sUrl="/",$sController="Homes",$sMethod="index")
    {
        $sNSClass = "\TheApplication\Controllers\\Controller$sController";
        self::$arUrls[]=["url"=>$sUrl,"controller"=>$sNSClass,"method"=>$sMethod];
    }
   
    public static function run()
    {
        self::add();
        self::$sReqUri = $_SERVER["REQUEST_URI"];
        foreach(self::$arUrls as $arUrl)
        {
            if($arUrl["url"]==self::$sReqUri)
            {
                self::$arRun = $arUrl;
                return self::$arRun;
            }
        }
        return [];
    }
   
}//ComponentRouter