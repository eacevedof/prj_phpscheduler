<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Components\ComponentScheduler 
 * @file component_scheduler.php 1.2.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheApplication\Components;

use TheApplication\Components\ComponentTopdf;
//use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputHidden;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperSelect;
use TheFramework\Helpers\HelperButtonBasic;

use TheApplication\Models\ModelSchedule;
use TheApplication\Models\ModelEmployee;

class ComponentScheduler 
{
    private $arMonth;
    private $iDayStart;
    private $iDayEnd;
    private $arEmployees;
    private $arSalon;
    private $arHours;
    private $arData;
    
    
    public function __construct() 
    {
        $this->arMonth = ["y"=>"","m"=>"","name"=>""];
        $this->arData = [];//mi1030,om12,day12
        
        $oEmployee = new ModelEmployee();
        $oEmployee->load();
        //array: empkey=>empname
        $this->arEmployees = $oEmployee->get_keyname();
        //los que pertenecen a salon van en rosa
        $this->arSalon = $oEmployee->get_by_workplace("salon");
        $this->fix_arrange_by_place();
        //bug($this->arSalon,"arSalon");die;
        $this->arHours = [""=>"...hour","1000"=>"10:00","1030"=>"10:30","1130"=>"11:30",
            "1200"=>"12:00","1230"=>"12:30","1300"=>"13:00","1330"=>"13:30",
            "1400"=>"14:00","1500"=>"15:00","off"=>"OFF"];
        $this->json_load();
    }
    
    private function fix_arrange_by_place()
    {
        $arSalonKeys = $this->arSalon;
        $arFull = $this->arEmployees;
        
        $arIn = [];
        $arNot = [];
        
        $arIn = array_filter($arFull,function($sEmpKey) use ($arSalonKeys){
            return (in_array($sEmpKey,$arSalonKeys));
        },ARRAY_FILTER_USE_KEY);
        
        $arNot = array_filter($arFull,function($sEmpKey) use ($arSalonKeys){
            return (!in_array($sEmpKey,$arSalonKeys));
        },ARRAY_FILTER_USE_KEY);
               
        foreach($arNot as $sEmpKey=>$sV)
            $arFullNew[$sEmpKey] = $arFull[$sEmpKey];
               
        foreach($arIn as $sEmpKey=>$sV)
            $arFullNew[$sEmpKey] = $arFull[$sEmpKey];
        
        $this->arEmployees = $arFullNew;
        
    }//fix_arrange_by_place    
    
    private function json_load()
    {
        $oSchedule = new ModelSchedule();
        $oSchedule->load();
        $this->arData = $oSchedule->get_data();
    }
    
    private function get_formatted_post()
    {
        $arFormatted = NULL;
        if($this->get_post("hidDay"))
        {
            $arDay = $this->get_post("hidDay");
            $arDay = $this->get_ardate($arDay);
            $sMonth = (string)$arDay["y"].$arDay["m"];
            $sDay = sprintf("%02d",$arDay["d"]);

            $arHours = $this->get_post("selHour");
            //pr($arHours);
            //pr($this->arHours);
            $arDay = [];
            foreach($this->arHours as $sKh=>$sVh)
            {
                foreach($arHours as $sEmp=>$sHour)
                    if($sKh==$sHour)
                        $arDay[$sHour][] = $sEmp;
            }
            
            $arFormatted[$sMonth][$sDay] = $arDay;
            //pr($arFormatted);die;
        }//if(post(hidday)
        return $arFormatted;
    }//get_formatted_post
    
    private function ar_merge(&$arMain,$arPiece)
    {
        $sYear = array_keys($arPiece);
        $sYear = (isset($sYear[0])?$sYear[0]:NULL);
        if($sYear)
        {
            if(!isset($arMain[$sYear]))
                $arMain[$sYear] = $arPiece[$sYear];
            else 
            {
                $sMonth = array_keys($arPiece[$sYear]);
                $sMonth = (isset($sMonth[0])?$sMonth[0]:NULL);
                if($sMonth)
                    $arMain[$sYear][$sMonth] = $arPiece[$sYear][$sMonth];
            }
        }
    }//ar_merge
    
    private function json_write($arPiece,$isAdd=1)
    {
        $oSchedule = new ModelSchedule();
        $oSchedule->load();
        
        $arTmp = $oSchedule->get_data();
        
        if($isAdd)
            $this->ar_merge($arTmp,$arPiece);
        $oSchedule->update($arTmp);
        
        $this->arData = $arTmp;
    }//json_write
        
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
        
        $this->iDayStart = $sYear.$sMonth."01";
        $this->iDayStart = (int) $this->iDayStart;
        $this->iDayEnd = date("Ymt",strtotime($this->iDayStart));
        $this->iDayEnd = (int) $this->iDayEnd;
        //$this->iEnd = $this->get_ardate($this->iEnd);
        //$this->iEnd = $this->iEnd["d"];
        //pr($this->iEnd);
        $this->arMonth["y"] = $sYear;
        $this->arMonth["m"] = $sMonth;
        
        $arOptions = [""=>"...year",date("Y")=>date("Y"),date("Y")+1=>date("Y")+1];
        $oSelYear = new HelperSelect($arOptions,"selYear","selYear");
        $oSelYear->set_value_to_select($this->arMonth["y"]);
        
        $arOptions = [""=>"...month",$sMonth=>$sMonth];
//        $sMonth = (int)date("m");
//        if($sMonth>2) $sMonth = $sMonth-2;
        //pr($sMonth);die;
        for($i=1; $i<13; $i++)
        {
            $sOpt = sprintf("%02d",$i);
            $arOptions[$sOpt] = $sOpt;
        }
        
        asort($arOptions);
        $oSelMonth = new HelperSelect($arOptions,"selMonth","selMonth");
        $oSelMonth->set_value_to_select($this->arMonth["m"]);
        
        $oButGo = new HelperButtonBasic("butMonth");
        $oButGo->set_innerhtml("Select Month");
        $oButGo->set_type("submit");
        
        $oButPdf = clone($oButGo);
        $oButPdf->set_innerhtml("Ver Horario");
        
        $oHidPdf = new HelperInputHidden("hidPdf");
        $oHidPdf->set_name("hidPdf");
        $oHidPdf->set_value($this->arMonth["y"].$this->arMonth["m"]);
        
        $sHtml = "<td>"
        . "<form method=\"post\" name=\"frmMonth\">"
        . "{$oSelMonth->get_html()} - {$oSelYear->get_html()} <br/>{$oButGo->get_html()}"
        . "</form>"
        . "</td>"
        . "<td align=\"left\">"
            
        . "<form method=\"post\" name=\"frmPdf\" action=\"/pdf/\" target=\"_blank\"\">"
        . "{$oHidPdf->get_html()} <br/>{$oButPdf->get_html()}"
        . "</form>"
        . "</td>";
      
        if(!isset($this->arData[$this->arMonth["y"].$this->arMonth["m"]])) 
        {
            $arPiece[$this->arMonth["y"].$this->arMonth["m"]] = [];
            $this->json_write($arPiece);
            $this->json_load();
        }
        return $sHtml;
    }//get_datepick
    
    private function get_hour($sYear,$sMonth,$sDay,$sEmp)
    {
        //bug($this->arData[$sYear.$sMonth]);die;
        $arHours = isset($this->arData[$sYear.$sMonth][$sDay])?$this->arData[$sYear.$sMonth][$sDay]:[];
        
        foreach($arHours as $sHour=>$arEmp)
        {
            if(in_array($sEmp,$arEmp))
                return $sHour;
        }
        return "";
    }
    
    private function get_tdform($iDay,$sDay="")
    {
        $arDate = $this->get_ardate($iDay);
        
        $oForm = new HelperForm();
        $oForm->set_id("frmDay[$iDay]");
        $sHtml = "";
        $sHtml .= $oForm->get_opentag();
        
        $oButton = new HelperButtonBasic("but$iDay");
        $oButton->set_type("submit");
        $oButton->set_innerhtml("Save $sDay");
        
        $oHid = new HelperInputHidden();
        $oHid->set_id("hidDay$iDay");
        $oHid->set_name("hidDay");
        $oHid->set_value($iDay);
        
        $sHtml .= $oHid->get_html();
            
        $iEmp = 0;
        //bug($iDay,"autofocus");bugp("hidDay");
        foreach($this->arEmployees as $kEmpl=>$sEmpl)
        {
            $sHour = $this->get_hour($arDate["y"],$arDate["m"],$arDate["d"],$kEmpl);
            $oSelHour = new HelperSelect($this->arHours,"selHour$iDay","selHour[$kEmpl]");
            $oSelHour->set_value_to_select($sHour);
            if($iDay==(isset($_POST["hidDay"])?$_POST["hidDay"]:NULL))
                $oSelHour->add_extras("autofocus","autofocus");
            if($iEmp%4==0) $sHtml.="<tr>";
            
            $sClass = "";
            if(in_array($kEmpl,$this->arSalon)) $sClass="background-color:#ffccff";
            $sHtml .= "<td style=\"$sClass\">$sEmpl</td><td style=\"$sClass\">{$oSelHour->get_html()}</td>";
            if($iEmp%4==(4-1)) $sHtml.="</tr>";
            $iEmp++;
        }
        
        $sHtml .= "<td>".$oButton->get_html()."</td>";
        $sHtml .= "</form>";
        return $sHtml;
    }//get_tdform

    private function json_save()
    {
        $arPiece = $this->get_formatted_post();
        if($arPiece !== NULL)
        {
            //pr($arPiece);die;
            $this->json_write($arPiece);
            $this->json_load();
        }
    }
    
    private function get_td($iDate)
    {
        $arDate = $this->get_ardate($iDate);
        $sDay = date("l",mktime(0,0,0,$this->arMonth["m"],$arDate["d"],$this->arMonth["y"]));
        $sHtml = "<b>{$sDay} {$arDate["d"]}</b><br/>";
        $sHtml .= "<table>";
        $sHtml .= "<tr>";
        $sHtml .= "<td>";
        $sHtml .= $this->get_tdform($iDate,$sDay);
        $sHtml .= "</td>";
        $sHtml .= "</tr></table>";
        return $sHtml;
    }
    
    public function run()
    {
        //$this->pdf();
        //bugp();
        //comprueba post para ver si hay algo q guardar. Lo guarda y recarga
        $this->json_save();
        //bug($this->arJson,"json loaded");
        //$iColRows = 2;
        
        $sDatePicker = $this->get_datepick();
        $sHtml = "<table class=\"table table-responsive table-hover\">";
        $sHtml .= "<tr>$sDatePicker</tr>";
        $this->arMonth["name"] = date("F",mktime(0,0,0,$this->arMonth["m"],10));
        $sHtml .= "<tr><th>{$this->arMonth["name"]}</th><th></th></tr>";
        //$iCol = 0;
        
        for($iFullDay=$this->iDayStart; $iFullDay<=$this->iDayEnd; $iFullDay++)
        {
            //$isStartCol = ($iCol%$iColRows)==0;
            //if($isStartCol)
                $sHtml .= "<tr>";
            //devuelve la celda con el form
            $sHtmlTD = $this->get_td($iFullDay);
            
            $sHtml .= "<td>";
            $sHtml .= $sHtmlTD;
            $sHtml .= "</td>";
            
            //$isEndCol = ($iCol%$iColRows)==($iColRows-1);
            //if($isEndCol)
                $sHtml .= "</tr>";
            //$iCol++;
        }//for
        
        //$sHtml .= "<tr><td>{$this->arMonth["name"]}</td><td>{$oButton->get_html()}</td></tr>";
        $sHtml .= "</table>";
        s($sHtml);
    }//run()
    
    public function set_path_file($value){$this->sFilePath=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}

    public function pdf()
    {
        if($this->get_post("hidPdf"))
        {
            $sMonth = $this->get_post("hidPdf");
            $arMonth = $this->get_ardate($sMonth);
            $this->iDayEnd = date("Ymt",strtotime($this->iDayStart));
            $this->iDayEnd = (int) $this->iDayEnd;
            $arData["month"]["asked"] = $sMonth;
            $arData["month"]["letters"] = date("F",mktime(0,0,0,$arMonth["m"],"01",$arMonth["y"]))." {$arMonth["y"]}";
            $arData["data"] = $this->arData[$sMonth];
            $arData["end"] = $this->iDayEnd;
            $arData["employees"] = $this->arEmployees;
            $arData["salon"] = $this->arSalon;
            $arData["hours"] = $this->arHours;
            
            $oToPdf = new ComponentTopdf($arData);
            $oToPdf->run();
            exit();
        }
    }
}//ComponentScheduler