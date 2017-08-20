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
    private $arMonth;
    private $iStart;
    private $iEnd;
    private $arEmployees;
    private $arHours;
    private $arConfig;
    private $arJson;
    
    public function __construct() 
    {
        $this->arMonth = ["y"=>"","m"=>"","name"=>""];
        $this->arConfig = ["pathroot"=>$_SERVER["DOCUMENT_ROOT"]];
        $this->arJson = ["path"=>"{$this->arConfig["pathroot"]}/the_application/schedule.json","data"=>[]];
        $this->arEmployees = ["rosana"=>"Rosanna","jesus"=>"Jesus","caty"=>"Caty","joel"=>"Joel","jose"=>"Jose"];
        $this->arHours = ["1000"=>"10:00","1130"=>"11:30","1230"=>"12:30","1330"=>"13:30","free"=>"Libre"];
        
        $this->json_load();
        //pr($this->arJson["data"]);
    }
    
    private function json_load()
    {
        $this->arJson["data"] = $this->json_read();
    }
    
    
    private function json_write($arPiece,$isAdd=1)
    {
        $sPath = $this->arJson["path"];
        $arTmp = $this->arJson["data"];
        
        //bug($arTmp);bug($arPiece);
        if($isAdd)
            $arTmp = $arTmp+$arPiece;
        
        $this->arJson["data"] = $arTmp;
        $sJson = json_encode($arTmp);
        file_put_contents($sPath,$sJson);
    }
    
    private function json_read()
    {
        $sPath = $this->arJson["path"];
        $sContent = file_get_contents($sPath);
        $arJson = json_decode($sContent,TRUE);
        return $arJson;
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
    
    private function get_post($sKey=NULL)
    {
        if($sKey)
        {
            if(isset($_POST[$sKey])) return $_POST[$sKey];
        }
        return NULL;
    }
    
    private function get_datepick()
    {
        $sMonth = date("m");
        $sYear = date("Y");
        
        if($this->get_post("selYear")) $sYear = $this->get_post("selYear");
        if($this->get_post("selMonth")) $sMonth = $this->get_post("selMonth");
        
        if($this->get_post("hidDay") && !$this->get_post("selMonth"))
        {
            $arDay = $this->get_ardate($this->get_post("hidDay"));
            $sYear = $arDay["y"]; $sMonth = $arDay["m"];
        }
        
        $this->iStart = $sYear.$sMonth."01";
        $this->iStart = (int) $this->iStart;
        $this->iEnd = date("Ymt",strtotime($this->iStart));
        $this->iEnd = (int) $this->iEnd;
        //$this->iEnd = $this->get_ardate($this->iEnd);
        //$this->iEnd = $this->iEnd["d"];
        pr($this->iEnd);
        $this->arMonth["m"] = $sMonth;
        $this->arMonth["y"] = $sYear;
        
        $arOptions = [""=>"...year",$sYear=>$sYear,$sYear+1=>$sYear+1];
        $oSelYear = new HelperSelect($arOptions,"selYear","selYear");
        $oSelYear->set_value_to_select($this->arMonth["y"]);
        
        $arOptions = [""=>"...month",$sMonth=>$sMonth];
        $sMonth = (int)date("m");
        //pr($sMonth);die;
        for($i=$sMonth; $i<13; $i++)
        {
            $sOpt = sprintf("%02d",$i);
            $arOptions[$sOpt] = $sOpt;
        }
        
        asort($arOptions);
        $oSelMonth = new HelperSelect($arOptions,"selMonth","selMonth");
        $oSelMonth->set_value_to_select($this->arMonth["m"]);
        
        $oButton = new HelperButtonBasic("butMonth");
        $oButton->set_innerhtml("Save month");
        $oButton->set_type("submit");
        
        $oHidden = new HelperInputHidden("hidAction");
        $oHidden->set_value("seldate");
        
        $sHtml = "<td>"
        . "<form method=\"post\" name=\"frmMonth\">"
        . "{$oSelMonth->get_html()} - {$oSelYear->get_html()} <br/>{$oButton->get_html()}"
        . "</form>"
        . "</td><td></td>";
      
        if(!isset($this->arJson["data"][$sYear.$sMonth])) 
        {
            $arPiece[$sYear.$sMonth] = [];
            $this->json_write($arPiece);
            $this->json_load();
        }
        return $sHtml;
    }
    
    
    private function get_tdform($iDate)
    {
        $arDate = $this->get_ardate($iDate);
        
        $oForm = new HelperForm();
        $oForm->set_id("frmDay[$iDate]");
        $sHtml = "";
        $sHtml .= $oForm->get_opentag();
        
        $oButton = new HelperButtonBasic("but$iDate");
        $oButton->set_type("submit");
        $oButton->set_innerhtml("Save day");
        
        $oHid = new HelperInputHidden();
        $oHid->set_id("hidDay$iDate");
        $oHid->set_name("hidDay");
        $oHid->set_value($iDate);
        
        $sHtml .= $oHid->get_html();
            
        foreach($this->arEmployees as $k=>$sEmpl)
        {
            $oSelHour = new HelperSelect($this->arHours,"selHour$iDate","selHour[$sEmpl]");
            $sHtml .= "<td>$sEmpl</td><td>{$oSelHour->get_html()}</td>";
        }
        
        $sHtml .= $oButton->get_html();
        $sHtml .= "</form>";
        return $sHtml;
    }


    private function get_td($iDate)
    {
        $arDate = $this->get_ardate($iDate);
        $sDay = date("l",mktime(0,0,0,$this->arMonth["m"],$arDate["d"], $this->arMonth["y"]));        
        $sHtml = "<b>{$sDay} {$arDate["d"]}</b><br/>";
        $sHtml .= "<table>";
        $sHtml .= "<tr>";
        $sHtml .= "<td>";
        $sHtml .= $this->get_tdform($iDate);
        $sHtml .= "</td>";
        $sHtml .= "</tr></table>";
        return $sHtml;
    }
    
    public function run($isPrintL=1)
    {
        bugp();
        $iColRows = 2;
        
        $sDatePicker = $this->get_datepick();
        $sHtml = "<table>";
        $sHtml .= "<tr>$sDatePicker</tr>";
        $this->arMonth["name"] = date("F",mktime(0,0,0,$this->arMonth["m"],10));
        $sHtml .= "<tr><th>{$this->arMonth["name"]}</th><th></th></tr>";
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
        //$sHtml .= "<tr><td>{$this->arMonth["name"]}</td><td>{$oButton->get_html()}</td></tr>";
        $sHtml .= "</table>";
        s($sHtml);
    }//run()
    
    public function set_path_file($value){$this->sFilePath=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}
    
}//ComponentScheduler