<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentTopdf
 * @file component_topdf.php 1.2.0
 * @date 01-06-2014 12:45
 * @observations
 */

namespace TheApplication\Components;

use FPDF;

class ComponentTopdf 
{
    private $arHead;
    private $arData; //array con datos
    private $iDayEnd; //end day
    
    public function __construct($arData)
    {
        //bugif();die;
        //pr($arData);die;
        $arTmp = array_values($arData["employees"]);
        sort($arTmp,SORT_STRING);
        $this->arHead["month"] = $arData["month"];
        $this->arHead["employees"]["full"] = $arData["employees"];
        $this->arHead["employees"]["names"] = $arTmp;
        $this->arHead["hours"] = $arData["hours"];
        $this->arHead["employees"]["salon"] = $arData["salon"];
        //bug($this->arHead,"arHead");die;
        //arData son los dias => horas => empleados
        $this->arData = $arData["data"];
        //pr($this->arData,"arData");die;
        $this->iDayEnd = (int)substr($arData["end"],6);
        
        $this->fix_arrange_by_place();
        //pr($this->iEnd);die;
        //bugif();
    }
    
    private function fix_arrange_by_place()
    {
        $arSalonKeys = $this->arHead["employees"]["salon"];
        $arFull = $this->arHead["employees"]["full"];
        //$arNames = $this->arHead["employees"]["names"];
        
        $arFullNew = [];
        
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
        
        $arNamesNew = array_values($arFullNew);
        
        //bug($arIn,"in");bug($arNot,"not");
        //bug($arNamesNew,"arNamesNew"); bug($arFullNew,"arFullNew");

        $this->arHead["employees"]["full"] = $arFullNew;
        $this->arHead["employees"]["names"] = $arNamesNew;
    }//fix_arrange_by_place
    
    private function get_hour($sKeyEmp,$sDay)
    {
        $arHours = (isset($this->arData[$sDay])?$this->arData[$sDay]:[]);
        if($arHours)
        {
            foreach($arHours as $sH=>$arEmp)
                if(in_array($sKeyEmp,$arEmp))
                    //return  strtoupper(substr($sH,0,2).":".substr($sH,2,2));
                    return  ($sH!=="off")?substr($sH,0,2).":".substr($sH,2,2):$sH;
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
        $oPdf->Cell(30,$iH,"EL CHALAN - Horas de entrada personal del mes: ".strtoupper($this->arHead["month"]["letters"]));
        //días
        $oPdf->SetX(0);
        for($iDay=0; $iDay<=$this->iDayEnd; $iDay++)
        {
            $oPdf->SetY(20);
            if($iDay==0)
            {
                $oPdf->SetX(0.5);
                $oPdf->MultiCell(25,$iH,"Dia /\nRRHH",1);
                $iX = 25+0.5;
            }
            else
            {
                $sDay = sprintf("%02d",$iDay);
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
        $arSalon = $this->arHead["employees"]["salon"];
        for($iEmp=0;$iEmp<count($this->arHead["employees"]["names"]); $iEmp++)
        {
            $sEmpName = $this->arHead["employees"]["names"][$iEmp];
            $sEmpKey = array_search($sEmpName,$this->arHead["employees"]["full"]);
            //bug("name:$sEmpName,key:$sEmpKey");die;
            $oPdf->SetY($oPdf->GetY());
            $oPdf->SetFillColor(255,255,255);
            //color rosa para salon
            if(in_array($sEmpKey,$arSalon)) $oPdf->SetFillColor(255,204,255);
            $oPdf->MultiCell(25,$iH,$sEmpName,1,"L",1);
        }//for Nombres
        
        $oPdf->SetFont("Arial","",7.5);
        $iX = 25.5;
        //dias
        for($iDay=1; $iDay<=$this->iDayEnd; $iDay++)
        {            
            $oPdf->SetY($iYHours);
            $sDay = sprintf("%02d",$iDay);
            //empleados
            $arEmp = $this->arHead["employees"]["full"];
            //asort($arEmp);
            //pr($arEmp);die;
            foreach($arEmp as $sK=>$sName)
            {
                $oPdf->SetX($iX);
                $sHour = $this->get_hour($sK,$sDay);
                $oPdf->SetFillColor(255,255,255);
                if($sHour=="10:00") $oPdf->SetFillColor(0,191,255);//blue
                elseif($sHour=="off") $oPdf->SetFillColor(255,165,0);//orange             
                $oPdf->MultiCell($iW,$iH,$sHour,1,"C",1);
            }//for empleados
            $iX = $iX+$iW;
        }//for dias
        $oPdf->Output();        
    }//run()
    
}//ComponentTopdf
