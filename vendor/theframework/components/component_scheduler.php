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

//use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputHidden;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperSelect;
use TheFramework\Helpers\HelperButtonBasic;

class ComponentScheduler 
{
    private $iStart;
    private $iEnd;
    private $arEmployees;
    private $arHours;
    private $arDays;
   
    public function __construct() 
    {
        $this->iStart = date("Ym01");
        $this->iEnd = date("Ymt");
        $this->arDays = [];
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
    
    private function get_td($iDate)
    {
        $arDate = $this->get_ardate($iDate);
        $sDate = date("l",mktime(0,0,0,$arDate["m"],$arDate["d"],$arDate["y"]));
        
        $sHtml = "<b>$sDate {$arDate["d"]}</b><br/>";
        $sHtml .= "<table>";
        $sHtml .= "<tr>";
        
        foreach($this->arEmployees as $k=>$sEmpl)
        {
            $id = "$iDate"."_$k";
            $oHid = new HelperInputHidden();
            $oHid->set_id("hid$id");
            $oHid->set_name("hid$id");
            $oHid->set_value("employee:$k");
            $oSelHour = new HelperSelect($this->arHours,"selHour$id","selHour$id");
            $sHtml .= "<td>$sEmpl {$oHid->get_html()}</td><td>{$oSelHour->get_html()}</td>";
        }
        
        $sHtml .= "</tr></table>";
        return $sHtml;
    }
    
    public function run($isPrintL=1)
    {
        bugp();
        $iColRows = 2;
        $oForm = new HelperForm();
        $oForm->show_opentag();
        
        $oButton = new HelperButtonBasic("butSend");
        $oButton->set_innerhtml("save");
        $oButton->set_type("submit");
        
        $sHtml = "<table>";
        $sMonth = date("F",mktime(0,0,0,date("m"),10)); // March
        $sHtml .= "<tr><th>$sMonth</th><th>{$oButton->get_html()}</th></tr>";
        $iCol = 0;
        for($i=$this->iStart; $i<=$this->iEnd; $i++)
        {
            $isStartCol = ($iCol%$iColRows)==0;
            if($isStartCol)
                $sHtml .= "<tr>";
            $sHtmlTD = $this->get_td($i);
            
            $sHtml .= "<td>";
            $sHtml .= $sHtmlTD;
            $sHtml .= "</td>";
            
            $isEndCol = ($iCol%$iColRows)==($iColRows-1);
            if($isEndCol)
                $sHtml .= "</tr>";
            $iCol++;
        }
        $sHtml .= "<tr><td>$sMonth</td><td>{$oButton->get_html()}</td></tr>";
        $sHtml .= "</table>";
        s($sHtml);
        $oForm->show_closetag();
    }//run()
    
    public function set_path_file($value){$this->sFilePath=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}
    
}//ComponentScheduler