<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentTopdf
 * @file component_topdf.php
 * @version 1.0.0
 * @date 01-06-2014 12:45
 * @observations
 */

namespace TheFramework\Components;

use FPDF;

class ComponentTopdf 
{
    private $arHead;
    private $arData; //array con datos
    private $iEnd; //end day
    
    public function __construct($arData)
    {
        //pr($arData);die;
        $arTmp = array_values($arData["employees"]);
        sort($arTmp,SORT_STRING);
        $this->arHead["month"] = $arData["month"];
        $this->arHead["employees"]["full"] = $arData["employees"];
        $this->arHead["employees"]["names"] = $arTmp;
        $this->arHead["hours"] = $arData["hours"];
        $this->arData = $arData["data"];
        //pr($this->arData);die;
        $this->iEnd = (int)substr($arData["end"],6);
        //pr($this->iEnd);die;
        //bugif();
    }
    
    private function get_hour($sKeyEmp,$sDay)
    {
        $arHours = (isset($this->arData[$sDay])?$this->arData[$sDay]:[]);
        if($arHours)
        {
            foreach($arHours as $sH=>$arEmp)
                if(in_array($sKeyEmp,$arEmp))
                    //return  strtoupper(substr($sH,0,2).":".substr($sH,2,2));
                    return  ($sH!=="free")?substr($sH,0,2).":".substr($sH,2,2):$sH;
        }
        return "";
    }
    
    private function get_ardate($sDate)
    {
        $arDate["y"] = substr($sDate,0,4);
        $arDate["m"] = substr($sDate,4,2);
        $arDate["d"] = substr($sDate,6,2);
        return $arDate;
    }
    
    private function get_day($sDate)
    {
        $arDate = $this->get_ardate($sDate);
        $sDay = date("l",mktime(0,0,0,$arDate["m"],$arDate["d"],$arDate["y"]));
        return substr($sDay,0,2);
    }
    
    public function run()
    {
        $oPdf = new FPDF();
        $oPdf->AddPage("L");
        $oPdf->SetMargins(0.5,0.5);
        
        $oPdf->SetFont("Courier","B",10);
        $iH = 8;
        $iW = 8.7;
        //bug($this->arHead);die;
        $oPdf->Cell(30,$iH,$this->arHead["month"]["letters"]);
        //días
        $oPdf->SetX(0);
        for($i=0; $i<=$this->iEnd; $i++)
        {
            $oPdf->SetY(20);
            if($i==0)
            {
                $oPdf->SetX(0.5);
                $oPdf->MultiCell(25,$iH,"Dia /\nRecurso",1);
                $iX = 25+0.5;
            }
            else
            {
                $sDay = sprintf("%02d",$i);
                $sDayFull = $this->arHead["month"]["asked"].$sDay;
                $sDayChar = $this->get_day($sDayFull);
                $oPdf->SetX($iX);
                $oPdf->SetFillColor(255,255,255);
                if($sDayChar=="Su") $oPdf->SetFillColor(2,252,31);
                $oPdf->MultiCell($iW,$iH,"$sDayChar\n$sDay",1,"C",1);
                $iX = $iX + $iW;
            }
        }//for(idays)
        
        $iYHours = $oPdf->GetY();//20
        //columna empleados
        //$arSalon = ["dayana","milenka","omayra"];
        $arSalon = ["Dayana","Milenka","Omayra"];
        for($i=0;$i<count($this->arHead["employees"]["names"]); $i++)
        {
            $sEmpName = $this->arHead["employees"]["names"][$i];
            $oPdf->SetY($oPdf->GetY());
            $oPdf->SetFillColor(255,255,255);
            if(in_array($sEmpName,$arSalon)) $oPdf->SetFillColor(245,149,255);
            $oPdf->MultiCell(25,$iH,$sEmpName,1,"L",1);
        }//for Nombres
        
        $oPdf->SetFont("Arial","",7.5);
        $iX = 25.5;
        //dias
        for($i=1; $i<=$this->iEnd; $i++)
        {            
            $oPdf->SetY($iYHours);
            $sDay = sprintf("%02d",$i);
            //empleados
            $arEmp = $this->arHead["employees"]["full"];
            //asort($arEmp);
            //pr($arEmp);die;
            foreach($arEmp as $sK=>$sName)
            {
                $oPdf->SetX($iX);
                $sHour = $this->get_hour($sK,$sDay);
                $oPdf->SetFillColor(255,255,255);
                if($sHour=="10:00") $oPdf->SetFillColor(1,160,252);
                elseif($sHour=="free") $oPdf->SetFillColor(252,168,0);                
                $oPdf->MultiCell($iW,$iH,$sHour,1,"C",1);
            }//for empleados
            $iX = $iX+$iW;
        }//for dias
        $oPdf->Output();        
    }//run()
    
}//ComponentTopdf
