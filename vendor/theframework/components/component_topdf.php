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
        //bugif();
    }
    
    public function run()
    {
        $oPdf = new FPDF();
        $oPdf->AddPage();
        $oPdf->SetFont("Arial","B",16);
        
        $x=40; $y=10;
        for($i=0; $i<=$this->iEnd; $i++)
        {
            $oPdf->Cell($x,$y,"algun texto con hh:mm");
            $x = $x+40;
            $y = $y+10;
        }
        $oPdf->Output();        
    }//run()
    
}//ComponentTopdf
