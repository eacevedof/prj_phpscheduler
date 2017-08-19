<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentScheduler
 * @file component_scheduler.php
 * @version 1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheFramework\Components;

use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperSelect;


class ComponentScheduler 
{
    private $iStart;
    private $iEnd;
    private $arEmployees;
    private $arHours;
    private $arDays;
   
    public function __construct() 
    {
        $this->iStart = date("m-01-Y");
        $this->iStart = date("Ym01");
        $this->iEnd = date("Ymt");
        $this->arDays = [];
        pr("istart: $this->iStart,iend:$this->iEnd");
        //bug("ComponentScheduler 1");
        $this->arEmployees = ["rosana"=>"Rosanna","jesus"=>"Jesus","caty"=>"Caty","joel"=>"Joel","jose"=>"Jose"];
        $this->arHours = ["1000"=>"10:00","1130"=>"11:30","1230"=>"12;30","free"=>"Libre"];
    }
    
    private function in_string($arChars=[],$sString)
    {
        foreach($arChars as $c)
            if(strstr($sString,$c))
                return TRUE;
        return FALSE;
    }
    
    private function clean($arSubstrings=[],&$sString)
    {
        $sReplace = $sString;
        foreach($arSubstrings as $str)
            $sReplace = str_replace ($str,"",$sReplace);
        $sString = $sReplace;
    }
    
    private function get_ardate($sDate)
    {
        $arDate["y"] = substr($sDate,0,4);
        $arDate["m"] = substr($sDate,4,2);
        $arDate["d"] = substr($sDate,6,2);
        return $arDate;
    }
    
    public function run($isPrintL=1)
    {
        $oSelEmpl = new HelperSelect($this->arEmployees);
        $oSelHour = new HelperSelect($this->arHours);
        
        $oForm = new HelperForm();
        $oForm->show_opentag();
        $sHtml = "<table>";
        $iCol = 0;
        for($i=$this->iStart;$i<=$this->iEnd;$i++)
        {
            $isStartCol = ($iCol%4)==0;
            if($isStartCol)
                $sHtml .= "<tr>";
            $arDate = $this->get_ardate($i);

            $sDate = date("l",mktime(0,0,0,$arDate["m"],$arDate["d"],$arDate["y"]));
            $sHtml .= "<td>";
            $sHtml .= "$sDate {$arDate["d"]}";            
            $sHtml .= "</td>";
            
            $isEndCol = ($iCol%4)==3;
            if($isEndCol)
                $sHtml .= "</tr>";
            $iCol++;
        }
        $sHtml .= "</table>";
        s($sHtml);
        $oForm->show_closetag();
    }//run()
    
    public function set_path_file($value){$this->sFilePath=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}
    
}//ComponentScheduler