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
    
    public function run()
    {
        $oPdf = new FPDF();
        $oPdf->AddPage("L");
        //$oPdf->SetX(0);
        //$oPdf->SetY(0);
        //$oPdf->SetFont("Arial","B",16);
        $oPdf->SetFont("Arial","B",10);
        
        $iW=8.6; $iH=8;
        
        //días
        for($i=0; $i<=$this->iEnd; $i++)
        {
            if($i==0)
                $oPdf->Cell(30,$iH,"Dia/Recurso",1);
            else
                $oPdf->Cell(8,$iH,sprintf("%02d",$i),1);
            //$x = $x + 2;
            //$y = $y+5;
        }
        
        $iY = $oPdf->GetY();//10.001249999999999
        //pr($iY);die;
        //$oPdf->SetY($oPdf->GetY()+8);
        //$oPdf->SetXY(8.5,8);
        for($i=0;$i<count($this->arHead["employees"]["names"]); $i++)
        {
            $oPdf->SetY($oPdf->GetY()+8);            
            $oPdf->Cell(30,$iH,$this->arHead["employees"]["names"][$i],1);
        }
        
        //dias
        $oPdf->SetFont("Arial","",5);
        for($i=1; $i<=$this->iEnd;$i++)
        {
            $sDay = sprintf("%02d",$i);
            //empleados
            foreach($this->arHead["employees"]["full"] as $sK=>$sName)
            {
                $sHour = $this->get_hour($sK,$sDay);
                $oPdf->SetY(10.001249999999999+8);
                $oPdf->SetX(40);
                $oPdf->Cell(8,$iH,$oPdf->GetY(),1);
            }
        }
        $oPdf->Output();        
    }//run()
    
}//ComponentTopdf
