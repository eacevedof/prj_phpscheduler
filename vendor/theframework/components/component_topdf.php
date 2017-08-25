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
        $this->arHead["employees"] = $arData["employees"];
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
        //$oPdf->SetFont("Arial","B",16);
        $oPdf->SetFont("Arial","B",10);
        
        $x=8.5; $y=10;
        for($i=0; $i<=$this->iEnd; $i++)
        {
            $oPdf->Cell($x,$y,($i!=0?sprintf("%02d",$i):"Dia/Recurso"));
            //$x = $x + 2;
            //$y = $y+5;
        }
        $oPdf->Output();        
    }//run()
    
}//ComponentTopdf
