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
                    return $sH;
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
        
        $oPdf->SetFont("Courier","B",7);
        $iH=8;
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
            }
            else
            {
                $sDay = sprintf("%02d",$i);
                $sDayFull = $this->arHead["month"]["asked"].$sDay;
                $sDayChar = $this->get_day($sDayFull);
                $oPdf->SetX(25.5);
                $oPdf->MultiCell(9,$iH,"$sDayChar\n$sDay",1);
            }
        }//for(idays)
        
        $iYHours = $oPdf->GetY();//20
        //pr($iYHours);die;
        for($i=0;$i<count($this->arHead["employees"]["names"]); $i++)
        {
            $oPdf->SetY($oPdf->GetY()+20);            
            $oPdf->Cell(25,$iH,$this->arHead["employees"]["names"][$i],1);
        }
        
        $oPdf->SetFont("Arial","",5);
        //dias
        for($i=1; $i<=$this->iEnd; $i++)
        {
            $sDay = sprintf("%02d",$i);
            //empleados
            foreach($this->arHead["employees"]["full"] as $sK=>$sName)
            {
                $sHour = $this->get_hour($sK,$sDay);
                $oPdf->SetY($iYHours+8);
                $oPdf->SetX(40*$i);
                $oPdf->Cell(8,$iH,$oPdf->GetY(),1);
            }
        }
        $oPdf->Output();        
    }//run()
    
}//ComponentTopdf
