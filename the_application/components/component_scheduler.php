<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Components\ComponentScheduler
 * @file component_scheduler.php
 * @version 1.0.1
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
        $oM = new ModelSchedule();
        $this->arMonth = ["y"=>"","m"=>"","name"=>""];
        $this->arConfig = ["pathroot"=>TFW_PATH_PROJECTDS];
        $this->arJson = ["path"=>TFW_PATH_APPLICATIONDS."models/json/schedule.json"
                        ,"data"=>[]];//mi1030,om12,day12
        $this->arEmployees = ["rosanna"=>"Rosanna","jesus"=>"Jesus","caty"=>"Caty","joel"=>"Joel","jose"=>"Jose"
            ,"dayana"=>"Dayana","milenka"=>"Milenka","omayra"=>"Omayra"];
        asort($this->arEmployees);
        $this->arHours = [""=>"...hour","1000"=>"10:00","1030"=>"10:30","1130"=>"11:30",
            "1200"=>"12:00","1230"=>"12:30","1300"=>"13:00","off"=>"OFF"];
        $this->json_load();
        //pr($this->arJson["data"]);
    }
    
    private function json_load()
    {
        $this->arJson["data"] = $this->json_read();
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
        $sPath = $this->arJson["path"];
        $arTmp = $this->arJson["data"];
        
        if($isAdd)
            $this->ar_merge($arTmp,$arPiece);
        $this->arJson["data"] = $arTmp;
        $sJson = json_encode($arTmp);
        file_put_contents($sPath,$sJson);
    }//json_write
    
    private function json_read()
    {
        $sPath = $this->arJson["path"];
        $sContent = file_get_contents($sPath);
        $arJson = json_decode($sContent,TRUE);
        return $arJson;
    }//json_read
        
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
        //pr($this->iEnd);
        $this->arMonth["y"] = $sYear;
        $this->arMonth["m"] = $sMonth;
        
        $arOptions = [""=>"...year",date("Y")=>date("Y"),date("Y")+1=>date("Y")+1];
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
        . "<form method=\"post\" name=\"frmPdf\" action=\"/pdf/\">"
        . "{$oHidPdf->get_html()} <br/>{$oButPdf->get_html()}"
        . "</form>"
        . "</td>";
      
        if(!isset($this->arJson["data"][$this->arMonth["y"].$this->arMonth["m"]])) 
        {
            $arPiece[$this->arMonth["y"].$this->arMonth["m"]] = [];
            $this->json_write($arPiece);
            $this->json_load();
        }
        return $sHtml;
    }//get_datepick
    
    private function get_hour($sYear,$sMonth,$sDay,$sEmp)
    {
        //bug($this->arJson["data"][$sYear.$sMonth]);die;
        $arHours = isset($this->arJson["data"][$sYear.$sMonth][$sDay])?$this->arJson["data"][$sYear.$sMonth][$sDay]:[];
        
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
            $sHtml .= "<td>$sEmpl</td><td>{$oSelHour->get_html()}</td>";
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
        $iColRows = 2;
        
        $sDatePicker = $this->get_datepick();
        $sHtml = "<table class=\"table table-responsive table-hover\">";
        $sHtml .= "<tr>$sDatePicker</tr>";
        $this->arMonth["name"] = date("F",mktime(0,0,0,$this->arMonth["m"],10));
        $sHtml .= "<tr><th>{$this->arMonth["name"]}</th><th></th></tr>";
        //$iCol = 0;
        
        for($i=$this->iStart; $i<=$this->iEnd; $i++)
        {
            //$isStartCol = ($iCol%$iColRows)==0;
            //if($isStartCol)
                $sHtml .= "<tr>";
            //devuelve la celda con el form
            $sHtmlTD = $this->get_td($i);
            
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
            $this->iEnd = date("Ymt",strtotime($this->iStart));
            $this->iEnd = (int) $this->iEnd;
            $arData["month"]["asked"] = $sMonth;
            $arData["month"]["letters"] = date("F",mktime(0,0,0,$arMonth["m"],"01",$arMonth["y"]))." {$arMonth["y"]}";
            $arData["data"] = $this->arJson["data"][$sMonth];
            $arData["end"] = $this->iEnd;
            $arData["employees"] = $this->arEmployees;
            $arData["hours"] = $this->arHours;
            
            //pr($arData,"arData");
            $oToPdf = new ComponentTopdf($arData);
            $oToPdf->run();
            exit();
        }
    }
}//ComponentScheduler