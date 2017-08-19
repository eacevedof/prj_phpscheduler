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

use TheFramework\Helpers\HelperLabel;
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
        $sHtml = "";
        $arDate = $this->get_ardate($iDate);
        $sDate = date("l",mktime(0,0,0,$arDate["m"],$arDate["d"],$arDate["y"]));
        
        $oLabel = new HelperLabel("sel$iDate");
        $oSelEmpl = new HelperSelect($this->arEmployees,"selEmpl$iDate","selEmpl$iDate",$oLabel);
        $oSelEmpl->set_multiple_size(3);
        $oSelHour = new HelperSelect($this->arHours,"selHour$iDate","selHour$iDate",$oLabel);
        
        $sHtml .= "$sDate {$arDate["d"]}<br/>";
        $sHtml .= $oSelEmpl->get_html();
        $sHtml .= "<br/>";
        $sHtml .= $oSelHour->get_html();
        
        
        return $sHtml;
    }
    
    public function run($isPrintL=1)
    {
        
        $oForm = new HelperForm();
        $oForm->show_opentag();
        $sHtml = "<table>";
        $sMonth = date("F",mktime(0,0,0,date("m"),10)); // March
        $sHtml .= "<tr><th>$sMonth</th></tr>";
        $iCol = 0;
        for($i=$this->iStart;$i<=$this->iEnd;$i++)
        {
            $isStartCol = ($iCol%4)==0;
            if($isStartCol)
                $sHtml .= "<tr>";
            $sHtmlTD = $this->get_td($i);
            
            $sHtml .= "<td>";
            $sHtml .= $sHtmlTD;
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