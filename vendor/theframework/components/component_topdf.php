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
        $this->arHead["employees"] = array_values($arData["employees"]);
        $this->arHead["hours"] = $arData["hours"];
        $this->arData = $arData["data"];
        $this->iEnd = (int)substr($arData["end"],6);
        //pr($this->iEnd);die;
        //bugif();
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
        
        $oPdf->SetY(15);
        $oPdf->SetXY(8.5,8);
        for($i=0; $i<count($this->arHead["employees"]); $i++)
        {
            $oPdf->Cell(30,$iH,$this->arHead["employees"][$i],1);
            $oPdf->SetY($oPdf->GetY()+8);
        }
        $oPdf->Output();        
    }//run()
    
}//ComponentTopdf
